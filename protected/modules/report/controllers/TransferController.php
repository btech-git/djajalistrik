<?php

class TransferController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'updateAllProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('transferCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('transferReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $transferHeader = Search::bind(new TransferHeader('search'), isset($_GET['TransferHeader']) ? $_GET['TransferHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $transferReport = new TransferReport($transferHeader->search());
        $transferReport->setupLoading();
        $transferReport->setupPaging($pageSize, $currentPage);
        $transferReport->setupSorting();
        $transferReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'transferReport' => $transferReport,
            'transferHeader' => $transferHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

}

?>