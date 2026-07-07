<?php

class PurchaseReceiptController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchaseReceiptReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $purchaseReceiptHeader = Search::bind(new PurchaseReceiptHeader('search'), isset($_GET['PurchaseReceiptHeader']) ? $_GET['PurchaseReceiptHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseReceiptReport = new PurchaseReceiptReport($purchaseReceiptHeader->search());
        $purchaseReceiptReport->setupLoading();
        $purchaseReceiptReport->setupPaging($pageSize, $currentPage);
        $purchaseReceiptReport->setupSorting();
        $purchaseReceiptReport->setupFilter($startDate, $endDate);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseReceiptReport, $startDate, $endDate);
        }

        $this->render('report', array(
            'purchaseReceiptReport' => $purchaseReceiptReport,
            'purchaseReceiptHeader' => $purchaseReceiptHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }
    
    protected function saveToExcel($purchaseReceiptReport, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Djaja Listrik');
        $documentProperties->setTitle('Tanda Terima Pembelian Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Tanda Terima Pembelian Barang');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Djaja Listrik');
        $worksheet->setCellValue('A2', 'Tanda Terima Pembelian Barang');
        $worksheet->setCellValue('A3', 'Tanggal: ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'TT Faktur #');
        $worksheet->setCellValue('B5', 'Tanggal TT');
        $worksheet->setCellValue('C5', 'Branch');
        $worksheet->setCellValue('D5', 'Supplier');
        $worksheet->setCellValue('E5', 'Admin');
        $worksheet->setCellValue('F5', 'Catatan');
        $worksheet->setCellValue('G5', 'Pembelian #');
        $worksheet->setCellValue('H5', 'Tanggal Pembelian');
        $worksheet->setCellValue('I5', 'Penerimaan #');
        $worksheet->setCellValue('J5', 'Tanggal Terima');
        $worksheet->setCellValue('K5', 'Faktur Pajak #');
        $worksheet->setCellValue('L5', 'Total');

        $worksheet->getStyle('A5:L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($purchaseReceiptReport->dataProvider->data as $header) {
            foreach ($header->purchaseReceiptDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'number'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'branch.code'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'supplier.company'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'admin.name'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($detail, 'receiveHeader.purchaseHeader.number'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail, 'receiveHeader.purchaseHeader.date'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'receiveHeader.number'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'receiveHeader.date'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'tax_number'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'amount'));

                $counter++;
            }
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="tanda_terima_pembelian.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
?>
