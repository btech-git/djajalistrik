<?php

class PurchaseNewItemSummary extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
        $this->dataProvider->criteria->together = TRUE;
		$this->dataProvider->criteria->with = array(
			'purchaseHeader'  			
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
//		$this->dataProvider->sort->attributes = array('purchaseHeader.date');
		$this->dataProvider->criteria->order = 'purchaseHeader.date DESC'; //$this->dataProvider->sort->orderBy;
	}
	
	public function setupFilter($startDate, $endDate)
	{
		$startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
		$endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        
		$this->dataProvider->criteria->addBetweenCondition('purchaseHeader.date', $startDate, $endDate);
		$this->dataProvider->criteria->compare('purchaseHeader.is_approved', 1);
		$this->dataProvider->criteria->compare('purchaseHeader.is_hold', 0);
		$this->dataProvider->criteria->compare('purchaseHeader.is_inactive', 0);
	}
	
//	public function setupBranch($branch)
//	{		
//		$this->dataProvider->criteria->compare('t.branch_id', $branch);
//	}
	
	public function getGrandTotal()
	{
		$grandTotal = 0.00;

		foreach ($this->dataProvider->data as $data)
			$grandTotal += $data->grandTotal;

		return $grandTotal;
	}
}
