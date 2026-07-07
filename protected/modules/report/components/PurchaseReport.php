<?php

class PurchaseReport extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
		$this->dataProvider->criteria->with = array(
			'purchaseDetails'=>array(
				'with'=>array(
					'product:resetScope'
				),
			),
			'branch:resetScope',
			'supplier:resetScope',
			'currency:resetScope',
		);
		
		//show data which is apporoved, not held, and active
		$this->dataProvider->criteria->compare('t.is_approved', 1);
		$this->dataProvider->criteria->compare('t.is_hold', 0);
		$this->dataProvider->criteria->compare('t.is_inactive', 0);
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
	
	public function setupFilter($startDate, $endDate)
	{
		$startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
		$endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
		$this->dataProvider->criteria->addBetweenCondition('date', $startDate, $endDate);
	}
	
//	public function getGrandTotal()
//	{
//		$total = 0.00;
//		
//		foreach ($this->dataProvider->data as $header)
//			foreach ($header->purchaseDetails as $detail)
//				$total += $detail->total;
//		
//		return $total;
//	}
	
	public function getTotalDetail()
	{
		$total = 0.00;
		foreach ($this->dataProvider->data as $header)
			foreach ($header->purchaseDetails as $detail)
				$total += $detail->total;
		
		return $total;
	}
	
	
	public function getTotalNewProduct()
	{
		$total = 0.00;
		foreach ($this->dataProvider->data as $header)
			foreach ($header->purchaseNewProducts as $newProduct)
				$total += $newProduct->total;
		
		return $total;
	}
	
//	public function getTotalPurchase()
//	{
//		foreach ($this->dataProvider->data as $header)
//		{
//			$subTotal = 0.00;
//			
//			if ((int)$this->is_tax === 0 && (int)$this->is_include === 0)
//				$subTotal = $this->grandTotal - $this->totalTax;
//			else
//				$subTotal = $this->totalDetail + $this->totalNewProduct;
//			
//			return $subTotal;
//		}
//	}
	
//	public function getTotalTax()
//	{
//		foreach ($this->dataProvider->data as $header)
//		{
//			if ((int)$this->is_tax === 0 && (int)$this->is_include === 0)
//				$taxValue = $this->grandTotal / 1.1 * .1;
//			elseif ((int)$this->is_tax === 0 && (int)$this->is_include === 1)
//				$taxValue = $this->subTotal * .1;
//			else
//				$taxValue = 0.00;
//			
//			return $taxValue;
//		}
//	}
	
	public function getGrandTotal()
	{
		$total = 0.00;
		
		foreach ($this->dataProvider->data as $header)
			$total += $header->grandTotal;
		
		return $total;
	}
}
