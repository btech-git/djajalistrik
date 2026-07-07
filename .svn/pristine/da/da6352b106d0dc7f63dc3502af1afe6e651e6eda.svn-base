<?php

class PurchaseItemReport extends CComponent
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
			'brand:resetScope',
			'productCategoryIdBulk:resetScope',
			'productCategoryIdSingle:resetScope',
		);
		
		//manual join because with is not working with one to many relation (product->purchaseDetails)
		$this->dataProvider->criteria->join = '
			JOIN tbldl_purchase_detail purchaseDetails ON purchaseDetails.product_id = t.id
			JOIN tbldl_purchase_header purchaseHeader ON purchaseHeader.id = purchaseDetails.purchase_header_id
			JOIN tbldl_supplier supplier ON supplier.id = purchaseHeader.supplier_id
		';
		
		//show data which is apporoved, not held, and active
		$this->dataProvider->criteria->compare('purchaseHeader.is_approved', 1);
		$this->dataProvider->criteria->compare('purchaseHeader.is_hold', 0);
		$this->dataProvider->criteria->compare('purchaseHeader.is_inactive', 0);
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
		$this->dataProvider->sort->attributes = array('name', 'productCategoryIdSingle.name');
		$this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
	}
	
	public function setupFilter($startDate, $endDate)
	{
		$startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
		$endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
		$this->dataProvider->criteria->addBetweenCondition('purchaseHeader.date', $startDate, $endDate);
	}
}