<?php

class OrderController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'ajaxJsonCustomer' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxJsonGrandTotal' || $filterChain->action->id === 'updateAllDiscount') {
            if (!(Yii::app()->user->checkAccess('orderCreate') || Yii::app()->user->checkAccess('orderEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail') {
            if (!(Yii::app()->user->checkAccess('orderCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('orderEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('orderReport')))
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

        $orderReport = new OrderReport($orderHeader->search());
        $orderReport->setupLoading();
        $orderReport->setupPaging($pageSize, $currentPage);
        $orderReport->setupSorting();
        $orderReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'orderReport' => $orderReport,
            'orderHeader' => $orderHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

}

?>
