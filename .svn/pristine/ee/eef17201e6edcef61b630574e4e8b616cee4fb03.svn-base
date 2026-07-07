<?php

class StockController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report' || $filterChain->action->id === 'check') {
            if (!(Yii::app()->user->checkAccess('adjustmentReport') || Yii::app()->user->checkAccess('transferReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCheck() {
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $dataProvider = $product->search();
        $dataProvider->criteria->with = array(
            'brand:resetScope',
        );
        
        $dataProvider->pagination->pageSize = 100;

        $warehouseId = '';
        if (isset($_GET['WarehouseId']))
            $warehouseId = $_GET['WarehouseId'];

        $this->render('check', array(
            'product' => $product,
            'warehouseId' => $warehouseId,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionReport() {
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $stockReport = new StockReport($product->search());
        $stockReport->setupLoading();
        $stockReport->setupPaging($pageSize, $currentPage);
        $stockReport->setupSorting();

        $this->render('report', array(
            'stockReport' => $stockReport,
            'product' => $product,
            'currentSort' => $currentSort,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    protected function reportStockBeginning($stockReport, $startDate) {
        $grandTotal = 0.00;

        foreach ($stockReport->dataProvider->data as $data)
            $grandTotal += $data->getStockBeginning($startDate);

        return $grandTotal;
    }

    protected function reportStockEnding($stockReport, $endDate) {
        $grandTotal = 0.00;

        foreach ($stockReport->dataProvider->data as $data)
            $grandTotal += $data->getStockEnding($endDate);

        return $grandTotal;
    }

    protected function reportStockIn($stockReport, $startDate, $endDate) {
        $grandTotal = 0.00;

        foreach ($stockReport->dataProvider->data as $data)
            $grandTotal += $data->getStockIn($startDate, $endDate);

        return $grandTotal;
    }

    protected function reportStockOut($stockReport, $startDate, $endDate) {
        $grandTotal = 0.00;

        foreach ($stockReport->dataProvider->data as $data)
            $grandTotal += $data->getStockOut($startDate, $endDate);

        return $grandTotal;
    }

}

?>