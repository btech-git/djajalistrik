<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $purchase_receipt_header_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property PurchasePaymentDetail[] $purchasePaymentDetails
 * @property PurchaseReceiptHeader $purchaseReceiptHeader
 * @property Branch $branch
 * @property Admin $admin
 */
class PurchasePaymentHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_purchase_payment_header';
	}

	public function rules()
	{
		return array(
			array('number, date, purchase_receipt_header_id, branch_id, admin_id', 'required'),
			array('purchase_receipt_header_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, purchase_receipt_header_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchasePaymentDetails' => array(self::HAS_MANY, 'PurchasePaymentDetail', 'purchase_payment_header_id'),
			'purchaseReceiptHeader' => array(self::BELONGS_TO, 'PurchaseReceiptHeader', 'purchase_receipt_header_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'note' => 'Note',
			'purchase_receipt_header_id' => 'Purchase Receipt Header',
			'branch_id' => 'Branch',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('number', $this->number, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('purchase_receipt_header_id', $this->purchase_receipt_header_id);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('admin_id', $this->admin_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}