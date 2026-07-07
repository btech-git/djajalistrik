<?php

class InvoiceReport extends CComponent {

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
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('t.date DESC');
        $this->dataProvider->criteria->order = 't.date DESC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
    }

    public function getGrandTotal() {
        $total = 0.00;

        foreach ($this->dataProvider->data as $header)
            $total += $header->grand_total;

        return $total;
    }

}
