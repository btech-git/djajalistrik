<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $grand_total
 * @property string $total_payment
 * @property string $note
 * @property integer $delivery_header_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property Branch $branch
 * @property Admin $admin
 * @property DeliveryHeader $deliveryHeader
 * @property SalePaymentHeader[] $salePaymentHeaders
 * @property SaleReceiptDetail[] $saleReceiptDetails
 * @property Taxform[] $taxforms
 */
class InvoiceBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_invoice';
	}

	public function rules()
	{
		return array(
			array('number, date, delivery_header_id, branch_id, admin_id', 'required'),
			array('delivery_header_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('grand_total, total_payment', 'length', 'max'=>18),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, grand_total, total_payment, note, delivery_header_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'deliveryHeader' => array(self::BELONGS_TO, 'DeliveryHeader', 'delivery_header_id'),
			'salePaymentHeaders' => array(self::HAS_MANY, 'SalePaymentHeader', 'invoice_id'),
			'saleReceiptDetails' => array(self::HAS_MANY, 'SaleReceiptDetail', 'invoice_id'),
			'taxforms' => array(self::HAS_MANY, 'Taxform', 'invoice_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'grand_total' => 'Grand Total',
			'total_payment' => 'Total Payment',
			'note' => 'Note',
			'delivery_header_id' => 'Delivery Header',
			'branch_id' => 'Branch',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.number', $this->number, true);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('t.grand_total', $this->grand_total, true);
		$criteria->compare('t.total_payment', $this->total_payment, true);
		$criteria->compare('t.note', $this->note, true);
		$criteria->compare('t.delivery_header_id', $this->delivery_header_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}