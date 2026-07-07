<?php

/**
 * @property integer $id
 * @property string $transaction_number
 * @property string $date
 * @property integer $transaction_type
 * @property string $transaction_subject
 * @property integer $quantity_in
 * @property integer $quantity_out
 * @property string $price
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property Branch $branch
 * @property Admin $admin
 * @property Warehouse $warehouse
 * @property Product $product
 * @property Unit $unit
 */
class InventoryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_inventory';
	}

	public function rules()
	{
		return array(
			array('transaction_number, date, transaction_subject, product_id, warehouse_id, branch_id, admin_id', 'required'),
			array('transaction_type, quantity_in, quantity_out, product_id, unit_id, warehouse_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('transaction_number, transaction_subject', 'length', 'max'=>60),
			array('price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, transaction_number, date, transaction_type, transaction_subject, quantity_in, quantity_out, price, product_id, unit_id, warehouse_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_number' => 'Transaction Number',
			'date' => 'Date',
			'transaction_type' => 'Transaction Type',
			'transaction_subject' => 'Transaction Subject',
			'quantity_in' => 'Quantity In',
			'quantity_out' => 'Quantity Out',
			'price' => 'Price',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
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
		$criteria->compare('transaction_number', $this->transaction_number, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('transaction_type', $this->transaction_type);
		$criteria->compare('transaction_subject', $this->transaction_subject, true);
		$criteria->compare('quantity_in', $this->quantity_in);
		$criteria->compare('quantity_out', $this->quantity_out);
		$criteria->compare('price', $this->price, true);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('unit_id', $this->unit_id);
		$criteria->compare('warehouse_id', $this->warehouse_id);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('admin_id', $this->admin_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}