<?php

class StockGlobalController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('adjustmentReport') || Yii::app()->user->checkAccess('transferReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $stockGlobalReport = new StockGlobalReport($product->search());
        $stockGlobalReport->setupLoading();
        $stockGlobalReport->setupPaging($pageSize, $currentPage);
        $stockGlobalReport->setupSorting();

        $this->render('report', array(
            'stockGlobalReport' => $stockGlobalReport,
            'product' => $product,
            'currentSort' => $currentSort,
            'endDate' => $endDate,
        ));
    }
}
?>