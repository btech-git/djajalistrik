<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $reference
 * @property string $note
 * @property integer $purchase_header_id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property PurchaseReceiptDetail[] $purchaseReceiptDetails
 * @property PurchaseReturnHeader[] $purchaseReturnHeaders
 * @property ReceiveDetail[] $receiveDetails
 * @property PurchaseHeader $purchaseHeader
 * @property Branch $branch
 * @property Admin $admin
 * @property Warehouse $warehouse
 * @property ReceiveNewProduct[] $receiveNewProducts
 */
class ReceiveHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_receive_header';
	}

	public function rules()
	{
		return array(
			array('number, date, purchase_header_id, warehouse_id, branch_id, admin_id', 'required'),
			array('purchase_header_id, warehouse_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number, reference', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, reference, note, purchase_header_id, warehouse_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseReceiptDetails' => array(self::HAS_MANY, 'PurchaseReceiptDetail', 'receive_header_id'),
			'purchaseReturnHeaders' => array(self::HAS_MANY, 'PurchaseReturnHeader', 'receive_header_id'),
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'receive_header_id'),
			'purchaseHeader' => array(self::BELONGS_TO, 'PurchaseHeader', 'purchase_header_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
			'receiveNewProducts' => array(self::HAS_MANY, 'ReceiveNewProduct', 'receive_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'reference' => 'Reference',
			'note' => 'Note',
			'purchase_header_id' => 'Purchase Header',
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
		$criteria->compare('t.reference', $this->reference, true);
		$criteria->compare('t.note', $this->note, true);
		$criteria->compare('t.purchase_header_id', $this->purchase_header_id);
		$criteria->compare('t.warehouse_id', $this->warehouse_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}