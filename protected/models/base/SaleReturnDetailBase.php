<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property integer $delivery_detail_id
 * @property integer $sale_return_header_id
 * @property integer $unit_id
 * @property integer $is_inactive
 * @property string $unit_price
 *
 * @property DeliveryDetail $deliveryDetail
 * @property SaleReturnHeader $saleReturnHeader
 * @property Unit $unit
 */
class SaleReturnDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_sale_return_detail';
	}

	public function rules()
	{
		return array(
			array('delivery_detail_id, sale_return_header_id, unit_id', 'required'),
			array('quantity, delivery_detail_id, sale_return_header_id, unit_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, quantity, delivery_detail_id, sale_return_header_id, unit_id, is_inactive, unit_price', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryDetail' => array(self::BELONGS_TO, 'DeliveryDetail', 'delivery_detail_id'),
			'saleReturnHeader' => array(self::BELONGS_TO, 'SaleReturnHeader', 'sale_return_header_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'delivery_detail_id' => 'Delivery Detail',
			'sale_return_header_id' => 'Sale Return Header',
			'unit_id' => 'Unit',
			'is_inactive' => 'Is Inactive',
			'unit_price' => 'Unit Price',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('quantity', $this->quantity);
		$criteria->compare('delivery_detail_id', $this->delivery_detail_id);
		$criteria->compare('sale_return_header_id', $this->sale_return_header_id);
		$criteria->compare('unit_id', $this->unit_id);
		$criteria->compare('is_inactive', $this->is_inactive);
		$criteria->compare('unit_price', $this->unit_price, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}