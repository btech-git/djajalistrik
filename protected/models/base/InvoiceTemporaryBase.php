<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $amount
 * @property string $date_receipt
 * @property string $note
 * @property string $return
 * @property string $amount_paid
 * @property string $date_payment
 * @property integer $customer_id
 * @property integer $payment_type_id
 * @property integer $is_paid
 * @property integer $is_inactive
 *
 * @property Customer $customer
 * @property PaymentType $paymentType
 * @property ReceiptTemporaryDetail[] $receiptTemporaryDetails
 */
class InvoiceTemporaryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_invoice_temporary';
	}

	public function rules()
	{
		return array(
			array('number, date, customer_id', 'required'),
			array('customer_id, payment_type_id, is_paid, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('amount, amount_paid', 'length', 'max'=>18),
			array('date_receipt, note, return, date_payment', 'safe'),
			// The following rule is used by search().
			array('id, number, date, amount, date_receipt, note, return, amount_paid, date_payment, customer_id, payment_type_id, is_paid, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
			'receiptTemporaryDetails' => array(self::HAS_MANY, 'ReceiptTemporaryDetail', 'invoice_temporary_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'amount' => 'Amount',
			'date_receipt' => 'Date Receipt',
			'note' => 'Note',
			'return' => 'Return',
			'amount_paid' => 'Amount Paid',
			'date_payment' => 'Date Payment',
			'customer_id' => 'Customer',
			'payment_type_id' => 'Payment Type',
			'is_paid' => 'Is Paid',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('number', $this->number, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('amount', $this->amount, true);
		$criteria->compare('date_receipt', $this->date_receipt, true);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('return', $this->return, true);
		$criteria->compare('amount_paid', $this->amount_paid, true);
		$criteria->compare('date_payment', $this->date_payment, true);
		$criteria->compare('customer_id', $this->customer_id);
		$criteria->compare('payment_type_id', $this->payment_type_id);
		$criteria->compare('is_paid', $this->is_paid);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}