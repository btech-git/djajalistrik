<?php

class DepositController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('depositReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $depositHeader = Search::bind(new DepositHeader('search'), isset($_GET['DepositHeader']) ? $_GET['DepositHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $depositReport = new DepositReport($depositHeader->search());
        $depositReport->setupLoading();
        $depositReport->setupPaging($pageSize, $currentPage);
        $depositReport->setupSorting();
        $depositReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'depositReport' => $depositReport,
            'depositHeader' => $depositHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

}