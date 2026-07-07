<?php

class PurchaseTaxReport extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'receiveHeader' => array(
                'with' => array(
                    'purchaseHeader' => array(
                        'with' => array(
                            'orderHeader',
                            'customer',
                        ),
                    ),
                ),
            ),
            'purchaseReceiptHeader' => array(
                'with' => array(
                    'supplier',
                    'branch',                    
                ),
            ),
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
//        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('purchaseReceiptHeader.date ASC');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $supplierId, $branchId) {
        
        $this->dataProvider->criteria->addBetweenCondition('purchaseReceiptHeader.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('purchaseReceiptHeader.supplier_id', $supplierId);
        $this->dataProvider->criteria->compare('purchaseReceiptHeader.branch_id', $branchId);
        $this->dataProvider->criteria->addCondition('purchaseHeader.is_tax = 0');
    }

}
