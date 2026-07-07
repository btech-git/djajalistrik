<?php

class SaleItemReport extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'orderDetails' => array(
                'with' => array(
                    'orderHeader'
                ),
            ),
            'brand:resetScope',
            'productCategoryIdBulk:resetScope',
            'productCategoryIdSingle:resetScope',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('name', 'orderHeader.date');
        $this->dataProvider->criteria->order = 'orderHeader.date DESC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('orderHeader.date', $startDate, $endDate);
    }

}
