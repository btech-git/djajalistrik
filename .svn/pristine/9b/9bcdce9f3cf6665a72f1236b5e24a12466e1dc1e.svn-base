<?php

class InvoiceOutstandingReport extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'orderHeader' => array(
                'with' => array(
                    'customer:resetScope',
                ),
            ),
            'branch:resetScope',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 500 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('t.date DESC');
        $this->dataProvider->criteria->order = 't.date DESC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($endDate) {
        $this->dataProvider->criteria->addCondition('t.is_approved = 1 AND t.is_inactive = 0 AND t.grand_total - COALESCE(t.total_payment, 0) > 100 AND t.date <= :end_date');
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}