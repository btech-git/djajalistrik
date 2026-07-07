<?php

class Supplier extends SupplierBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getRemainingCreditLimit()
	{
		$totalRemaining = 0.00;
		
		foreach ($this->purchaseReceiptHeaders as $purchaseReceiptHeader)
		{
			$totalRemaining += $purchaseReceiptHeader->remaining;
		}
		
		return $this->credit_limit - $totalRemaining;
	}
}