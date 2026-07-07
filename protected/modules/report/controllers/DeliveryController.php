<?php

class DeliveryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddDetail' || $filterChain->action->id === 'ajaxJsonOrder' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'updateAllProduct' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('deliveryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $deliveryHeader = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';

        $deliveryReport = new DeliveryReport($deliveryHeader->search());
        $deliveryReport->setupLoading();
        $deliveryReport->setupPaging($pageSize, $currentPage);
        $deliveryReport->setupSorting();
        $deliveryReport->setupFilter($startDate, $endDate, $customerId);

        $this->render('report', array(
            'deliveryReport' => $deliveryReport,
            'deliveryHeader' => $deliveryHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerId' => $customerId,
        ));
    }

}

?>
