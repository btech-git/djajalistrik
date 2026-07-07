<?php

class QuotationDetail extends QuotationDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotal()
	{
		return (((((($this->quantity * $this->unit_price * (1 + ($this->discount_1 / 100))) * (1 + ($this->discount_2 / 100))) * (1 + ($this->discount_3 / 100))) * (1 + ($this->discount_4 / 100))) * (1 + ($this->discount_5 / 100)))*(1 + ($this->quotation_value/ 100)));
	}
	
	public function getunitPrice()
	{
		return (((((($this->unit_price * (1 + ($this->discount_1 / 100))) * (1 + ($this->discount_2 / 100))) * (1 + ($this->discount_3 / 100))) * (1 + ($this->discount_4 / 100))) * (1 + ($this->discount_5 / 100)))*(1 + ($this->quotation_value/ 100)));
	}
}