<?php

class PurchasePaymentController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        $purchasePaymentHeader = Search::bind(new PurchasePaymentHeader('search'), isset($_GET['PurchasePaymentHeader']) ? $_GET['PurchasePaymentHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : 0;

        $purchasePaymentReport = new PurchasePaymentReport($purchasePaymentHeader->search());
        $purchasePaymentReport->setupLoading();
        $purchasePaymentReport->setupPaging($pageSize, $currentPage);
        $purchasePaymentReport->setupSorting();
        $purchasePaymentReport->setupFilter($startDate, $endDate, $supplierId);

        $this->render('report', array(
            'supplierId' => $supplierId,
            'purchasePaymentReport' => $purchasePaymentReport,
            'purchasePaymentHeader' => $purchasePaymentHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }
}
?>
