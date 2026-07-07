<?php

class SaleReturnHeader extends SaleReturnHeaderBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getGrandTotal()
	{
		$grandTotal = 0.00;

		foreach ($this->saleReturnDetails as $detail)
			$grandTotal += $detail->getTotal();

		return $grandTotal;
	}
}