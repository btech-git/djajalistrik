<?php

class AdjustmentController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'view' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'updateAllProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail') {
            if (!(Yii::app()->user->checkAccess('adjustmentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('adjustmentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $adjustmentHeader = Search::bind(new AdjustmentHeader('search'), isset($_GET['AdjustmentHeader']) ? $_GET['AdjustmentHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $adjustmentReport = new AdjustmentReport($adjustmentHeader->search());
        $adjustmentReport->setupLoading();
        $adjustmentReport->setupPaging($pageSize, $currentPage);
        $adjustmentReport->setupSorting();
        $adjustmentReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'adjustmentReport' => $adjustmentReport,
            'adjustmentHeader' => $adjustmentHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

}

?>