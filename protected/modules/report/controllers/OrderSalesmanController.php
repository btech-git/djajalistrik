<?php

class OrderSalesmanController extends Controller {

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
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $orderHeader = Search::bind(new OrderHeader('search'), isset($_GET['OrderHeader']) ? $_GET['OrderHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $salesmanId = (isset($_GET['SalesmanId'])) ? $_GET['SalesmanId'] : '';

        $orderSalesmanReport = new OrderSalesmanReport($orderHeader->searchBySalesman());
        $orderSalesmanReport->setupLoading();
        $orderSalesmanReport->setupPaging($pageSize, $currentPage);
        $orderSalesmanReport->setupSorting();
        $orderSalesmanReport->setupFilter($startDate, $endDate, $salesmanId);

        $this->render('report', array(
            'orderSalesmanReport' => $orderSalesmanReport,
            'orderHeader' => $orderHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'salesmanId' => $salesmanId
        ));
    }

}
