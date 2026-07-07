<?php

class AgingScheduleReport extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading($startDate, $endDate)
	{
		$this->dataProvider->criteria->compare('deliveryHeader.customer_id', $customerId);
		$this->dataProvider->criteria->join = "INNER JOIN " . DeliveryHeader::model()->tableName() . " deliveryHeader ON deliveryHeader.id = t.delivery_header_id INNER JOIN " . Customer::model()->tableName() . " customer ON deliveryHeader.customer_id = customer.id
										LEFT OUTER JOIN ". ReceiptDetail::model()->tableName() ." receiptDetail ON t.id = receiptDetail.invoice_header_id ";
		$this->dataProvider->criteria->addCondition(SqlViewGenerator::agingReceivable());
		$this->dataProvider->criteria->with = array(
			'orderHeaders' => array(
				'condition' => "date BETWEEN :startDate AND :endDate", 
				'params' => array(':startDate' => $startDate, ':endDate' => $endDate),
			),
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
		$this->dataProvider->sort->attributes = array('company', 'name');
		$this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
	}
	
	public function setupFilter($startDate, $endDate)
	{
		$startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
		$endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
//		$this->dataProvider->criteria->addBetweenCondition('date', $startDate, $endDate);
	}
}
