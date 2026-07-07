<?php

class ExpenseController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('expenseReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $expenseHeader = Search::bind(new ExpenseHeader('search'), isset($_GET['ExpenseHeader']) ? $_GET['ExpenseHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $expenseReport = new ExpenseReport($expenseHeader->search());
        $expenseReport->setupLoading();
        $expenseReport->setupPaging($pageSize, $currentPage);
        $expenseReport->setupSorting();
        $expenseReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'expenseReport' => $expenseReport,
            'expenseHeader' => $expenseHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

}