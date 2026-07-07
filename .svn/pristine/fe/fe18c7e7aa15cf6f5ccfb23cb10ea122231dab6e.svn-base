<?php

class InvoiceDetail extends InvoiceDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getDiscountValue() {
        return ((((((1 + ($this->discount_1 / 100))) * (1 + ($this->discount_2 / 100))) * (1 + ($this->discount_3 / 100))) * (1 + ($this->discount_4 / 100))) * (1 + ($this->discount_5 / 100)));
    }

    public function getPriceAfterDiscount() {
        return $this->unit_price * $this->discountValue;
    }
    
    public function getTotal() {
        return $this->quantity * $this->priceAfterDiscount;
    }
}