<?php

class QuotationHeader extends QuotationHeaderBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getSubTotal()
	{
		$total = 0.00;
		
		foreach ($this->quotationDetails as $detail)
			$total += $detail->total;
		
		return $total;
	}
	
	public function getGrandTotal()
	{
		return $this->subTotal;
	}
}