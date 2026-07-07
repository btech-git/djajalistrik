<?php

class InvoiceTemporary extends InvoiceTemporaryBase
{
	const UNPAID = 0;
	const PAID = 1;
	
	const UNPAID_LITERAL = 'Belum Lunas';
	const PAID_LITERAL = 'Lunas';
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function paymentStatus()
	{
		return ($this->is_paid) ? self::PAID_LITERAL : self::UNPAID_LITERAL;
	}
	
	public function searchByReceiptTemporary()
	{
		$criteria = new CDbCriteria;

		$criteria->condition = "t.id NOT IN (SELECT invoice_temporary_id FROM tbldl_receipt_temporary_detail d INNER JOIN tbldl_receipt_temporary_header h ON h.id = d.receipt_temporary_header_id WHERE h.is_inactive = 0 AND d.is_inactive = 0)";

		$criteria->compare('t.number', $this->number, true);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('t.customer_id',$this->customer_id);
		$criteria->compare('t.payment_type_id',$this->payment_type_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}
}