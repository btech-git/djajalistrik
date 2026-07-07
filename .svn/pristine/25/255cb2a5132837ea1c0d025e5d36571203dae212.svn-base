<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property integer $note
 * @property integer $warehouse_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property integer $branch_id
 * @property integer $order_header_id
 *
 * @property DeliveryHeader[] $deliveryHeaders
 * @property PackingListDetail[] $packingListDetails
 * @property Branch $branch
 * @property OrderHeader $orderHeader
 * @property Warehouse $warehouse
 * @property Admin $admin
 */
class PackingListHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_packing_list_header';
	}

	public function rules()
	{
		return array(
			array('number, date, warehouse_id, admin_id, branch_id, order_header_id', 'required'),
			array('note, warehouse_id, admin_id, is_inactive, branch_id, order_header_id', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, number, date, note, warehouse_id, admin_id, is_inactive, branch_id, order_header_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'packing_list_header_id'),
			'packingListDetails' => array(self::HAS_MANY, 'PackingListDetail', 'packing_list_header_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'orderHeader' => array(self::BELONGS_TO, 'OrderHeader', 'order_header_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
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
			'warehouse_id' => 'Warehouse',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
			'branch_id' => 'Branch',
			'order_header_id' => 'Order Header',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('number', $this->number, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('note', $this->note);
		$criteria->compare('warehouse_id', $this->warehouse_id);
		$criteria->compare('admin_id', $this->admin_id);
		$criteria->compare('is_inactive', $this->is_inactive);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('order_header_id', $this->order_header_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}