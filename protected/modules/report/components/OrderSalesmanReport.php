<?php

class OrderSalesmanReport extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
		$this->dataProvider->criteria->with = array(
			'customer:resetScope' => array(
                            'with' => 'salesman:resetScope'
                        ),
			'branch:resetScope',
		);
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
		$this->dataProvider->sort->attributes = array('date', 'number');
		$this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
	}
	
	public function setupFilter($startDate, $endDate, $salesmanId)
	{
		$startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
		$endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
		$this->dataProvider->criteria->addBetweenCondition('date', $startDate, $endDate);
                $this->dataProvider->criteria->compare('customer.salesman_id', $salesmanId);
	}
	
	public function getGrandTotal()
	{
		$total = 0.00;
		
		foreach ($this->dataProvider->data as $header)
				$total += $header->grandTotal;
		
		return $total;
	}
}
