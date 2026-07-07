<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $delivery_header_id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property SaleReturnDetail[] $saleReturnDetails
 * @property DeliveryHeader $deliveryHeader
 * @property Branch $branch
 * @property Admin $admin
 * @property Warehouse $warehouse
 * @property SaleReturnNewProduct[] $saleReturnNewProducts
 */
class SaleReturnHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_sale_return_header';
	}

	public function rules()
	{
		return array(
			array('number, date, delivery_header_id, warehouse_id, branch_id, admin_id', 'required'),
			array('delivery_header_id, warehouse_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, delivery_header_id, warehouse_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'saleReturnDetails' => array(self::HAS_MANY, 'SaleReturnDetail', 'sale_return_header_id'),
			'deliveryHeader' => array(self::BELONGS_TO, 'DeliveryHeader', 'delivery_header_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
			'saleReturnNewProducts' => array(self::HAS_MANY, 'SaleReturnNewProduct', 'sale_return_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'note' => 'Note',
			'delivery_header_id' => 'Delivery Header',
			'warehouse_id' => 'Warehouse',
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
		$criteria->compare('delivery_header_id', $this->delivery_header_id);
		$criteria->compare('warehouse_id', $this->warehouse_id);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('admin_id', $this->admin_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}