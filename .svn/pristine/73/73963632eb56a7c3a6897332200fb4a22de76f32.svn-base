<?php

class InvoiceController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'taxform' || $filterChain->action->id === 'ajaxHtmlShowOrder' || $filterChain->action->id === 'ajaxJsonOrder' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('invoiceCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('invoiceEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('invoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $invoiceReport = new InvoiceReport($invoice->search());
        $invoiceReport->setupLoading();
        $invoiceReport->setupPaging($pageSize, $currentPage);
        $invoiceReport->setupSorting();
        $invoiceReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'invoiceReport' => $invoiceReport,
            'invoice' => $invoice,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }
}
