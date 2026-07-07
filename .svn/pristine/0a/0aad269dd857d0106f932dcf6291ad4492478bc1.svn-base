<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $amount
 * @property string $cheque_number
 * @property string $note
 * @property integer $customer_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_cheque
 * @property integer $is_item_ready
 * @property integer $is_delivery_ready
 * @property integer $is_inactive
 *
 * @property ReceiptTemporaryDetail[] $receiptTemporaryDetails
 * @property Admin $admin
 * @property Customer $customer
 * @property Branch $branch
 */
class ReceiptTemporaryHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_receipt_temporary_header';
	}

	public function rules()
	{
		return array(
			array('number, date, customer_id, branch_id, admin_id', 'required'),
			array('customer_id, branch_id, admin_id, is_cheque, is_item_ready, is_delivery_ready, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number, cheque_number', 'length', 'max'=>60),
			array('amount', 'length', 'max'=>18),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, amount, cheque_number, note, customer_id, branch_id, admin_id, is_cheque, is_item_ready, is_delivery_ready, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'receiptTemporaryDetails' => array(self::HAS_MANY, 'ReceiptTemporaryDetail', 'receipt_temporary_header_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'amount' => 'Amount',
			'cheque_number' => 'Cheque Number',
			'note' => 'Note',
			'customer_id' => 'Customer',
			'branch_id' => 'Branch',
			'admin_id' => 'Admin',
			'is_cheque' => 'Is Cheque',
			'is_item_ready' => 'Is Item Ready',
			'is_delivery_ready' => 'Is Delivery Ready',
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
		$criteria->compare('cheque_number', $this->cheque_number, true);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('customer_id', $this->customer_id);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('admin_id', $this->admin_id);
		$criteria->compare('is_cheque', $this->is_cheque);
		$criteria->compare('is_item_ready', $this->is_item_ready);
		$criteria->compare('is_delivery_ready', $this->is_delivery_ready);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}