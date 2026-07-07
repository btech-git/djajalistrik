<?php

class PurchasePaymentDetail extends PurchasePaymentDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalReceipt()
	{
		return $total = ($this->header->purchaseReceiptHeader === null) ? 0.00 : $this->header->purchaseReceiptHeader->totalDetail;
	}
}