<?php

class SaleCustomerReport extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
        $this->dataProvider->criteria->join = '
			JOIN tbldl_order_header orderHeader ON orderHeader.customer_id = t.id
		';
		$this->dataProvider->criteria->with = array('orderHeaders');
	}
	
	public function setupPaging($pageSize, $currentPage)
	{
		$pageSize = (empty($pageSize)) ? 10 : $pageSize;
		$pageSize = ($pageSize <= 0) ? 1 : $pageSize;
		$this->dataProvider->pagination->pageSize = $pageSize;
		
		$currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
		$this->dataProvider->pagination->currentPage = $currentPage;
	}
	
	public function setupSorting()
	{
		$this->dataProvider->sort->attributes = array('company', 'name');
		$this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
	}
	
	public function setupFilter($startDate, $endDate)
	{
		$startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
		$endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
                $this->dataProvider->criteria->addBetweenCondition('orderHeader.date', $startDate, $endDate);
                
//		$this->dataProvider->criteria->with = array('orderHeaders' => array(
//			'condition' => "date BETWEEN :startDate AND :endDate", 
//			'params' => array(':startDate' => $startDate, ':endDate' => $endDate),
//		));
	}
}
