<?php

class PurchaseReturnController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxJsonReceive' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $purchaseReturnHeader = Search::bind(new PurchaseReturnHeader('search'), isset($_GET['PurchaseReturnHeader']) ? $_GET['PurchaseReturnHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';

        $purchaseReturnReport = new PurchaseReturnReport($purchaseReturnHeader->search());
        $purchaseReturnReport->setupLoading();
        $purchaseReturnReport->setupPaging($pageSize, $currentPage);
        $purchaseReturnReport->setupSorting();
        $purchaseReturnReport->setupFilter($startDate, $endDate, $supplierId);

        $this->render('report', array(
            'purchaseReturnReport' => $purchaseReturnReport,
            'purchaseReturnHeader' => $purchaseReturnHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierId' => $supplierId,
        ));
    }
}

?>