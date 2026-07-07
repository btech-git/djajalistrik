<?php

class ReceiptTemporaryHeader extends ReceiptTemporaryHeaderBase
{
	const CASH = 0;
	const CHEQUE = 1;
	const ITEM_NOT_READY = 0;
	const ITEM_PENDING = 1;
	const ITEM_READY = 2;
	const DELIVERY_NOT_READY = 0;
	const DELIVERY_READY = 1;
	
	const CASH_LITERAL = 'Cash';
	const CHEQUE_LITERAL = 'Giro';
	const ITEM_NOT_READY_LITERAL = 'Barang Belum Siap';
	const ITEM_PENDING_LITERAL = 'Pending';
	const ITEM_READY_LITERAL = 'Barang Siap';
	const DELIVERY_NOT_READY_LITERAL = 'Belum Siap Kirim';
	const DELIVERY_READY_LITERAL = 'Siap Kirim';
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function paymentMethod()
	{
		return ($this->is_cheque) ? self::CHEQUE_LITERAL : self::CASH_LITERAL;
	}
	
	public function itemReady()
	{
		return ($this->is_item_ready) ? self::ITEM_READY_LITERAL : self::ITEM_NOT_READY_LITERAL;
	}
	
	public function deliveryReady()
	{
		return ($this->is_delivery_ready) ? self::DELIVERY_READY_LITERAL : self::DELIVERY_NOT_READY_LITERAL;
	}
	
}