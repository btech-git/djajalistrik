<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $customer_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property QuotationDetail[] $quotationDetails
 * @property Customer $customer
 * @property Branch $branch
 * @property Admin $admin
 */
class QuotationHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_quotation_header';
	}

	public function rules()
	{
		return array(
			array('number, date, customer_id, branch_id, admin_id', 'required'),
			array('customer_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, customer_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'quotationDetails' => array(self::HAS_MANY, 'QuotationDetail', 'quotation_header_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
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
			'customer_id' => 'Customer',
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
		$criteria->compare('t.note', $this->note, true);
		$criteria->compare('t.customer_id', $this->customer_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}