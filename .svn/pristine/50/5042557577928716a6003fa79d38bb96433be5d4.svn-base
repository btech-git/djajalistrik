<?php

class PurchaseTaxController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchaseReceiptReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionReport() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $purchaseReceiptDetail = Search::bind(new PurchaseReceiptDetail('search'), isset($_GET['PurchaseReceiptDetail']) ? $_GET['PurchaseReceiptDetail'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $purchaseTaxReport = new PurchaseTaxReport($purchaseReceiptDetail->search());
        $purchaseTaxReport->setupLoading();
        $purchaseTaxReport->setupPaging($pageSize, $currentPage);
        $purchaseTaxReport->setupSorting();
        $purchaseTaxReport->setupFilter($startDate, $endDate, $supplierId, $branchId);

        $this->render('report', array(
            'purchaseTaxReport' => $purchaseTaxReport,
            'purchaseReceiptDetail' => $purchaseReceiptDetail,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierId' => $supplierId,
            'branchId' => $branchId,
        ));
    }
}
?>
