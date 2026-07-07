<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $receive_header_id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property PurchaseReturnDetail[] $purchaseReturnDetails
 * @property ReceiveHeader $receiveHeader
 * @property Branch $branch
 * @property Admin $admin
 * @property Warehouse $warehouse
 * @property PurchaseReturnNewProduct[] $purchaseReturnNewProducts
 */
class PurchaseReturnHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_purchase_return_header';
	}

	public function rules()
	{
		return array(
			array('number, date, receive_header_id, warehouse_id, branch_id, admin_id', 'required'),
			array('receive_header_id, warehouse_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, receive_header_id, warehouse_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseReturnDetails' => array(self::HAS_MANY, 'PurchaseReturnDetail', 'purchase_return_header_id'),
			'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
			'purchaseReturnNewProducts' => array(self::HAS_MANY, 'PurchaseReturnNewProduct', 'purchase_return_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'note' => 'Note',
			'receive_header_id' => 'Receive Header',
			'warehouse_id' => 'Warehouse',
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
		$criteria->compare('t.receive_header_id', $this->receive_header_id);
		$criteria->compare('t.warehouse_id', $this->warehouse_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}