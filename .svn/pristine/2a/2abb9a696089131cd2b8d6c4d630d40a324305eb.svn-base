<?php

class InvoiceOutstandingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('invoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';

        $invoiceOutstandingReport = new InvoiceOutstandingReport($invoiceHeader->search());
        $invoiceOutstandingReport->setupLoading();
        $invoiceOutstandingReport->setupPaging($pageSize, $currentPage);
        $invoiceOutstandingReport->setupSorting();
        $invoiceOutstandingReport->setupFilter($endDate);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($invoiceOutstandingReport, $endDate);
        }

        $this->render('report', array(
            'invoiceOutstandingReport' => $invoiceOutstandingReport,
            'invoiceHeader' => $invoiceHeader,
            'endDate' => $endDate,
        ));
    }
    
    protected function saveToExcel($invoiceOutstandingReport, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Djaja Listrik');
        $documentProperties->setTitle('Invoice Outstanding');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Invoice Outstanding');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Djaja Listrik');
        $worksheet->setCellValue('A2', 'Invoice Outstanding');
        $worksheet->setCellValue('A3', 'Periode: ' . Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Invoice #');
        $worksheet->setCellValue('B5', 'Branch');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'TOP (hari)');
        $worksheet->setCellValue('E5', 'Jatuh Tempo');
        $worksheet->setCellValue('F5', 'Customer');
        $worksheet->setCellValue('G5', 'PO Customer');
        $worksheet->setCellValue('H5', 'F. Pajak #');
        $worksheet->setCellValue('I5', 'Total');
        $worksheet->setCellValue('J5', 'Jumlah');
        $worksheet->setCellValue('K5', 'Sisa');

        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($invoiceOutstandingReport->dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'branch.code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'payment_term'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'due_date'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.company'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'orderHeader.reference_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'tax_number'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'grand_total'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'total_payment'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'remaining'));

            $counter++;
        }

        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="invoice_outstanding.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
