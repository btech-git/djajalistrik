<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $sale_return_header_id
 * @property integer $delivery_new_product_id
 * @property integer $is_inactive
 *
 * @property SaleReturnHeader $saleReturnHeader
 * @property DeliveryNewProduct $deliveryNewProduct
 */
class SaleReturnNewProductBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_sale_return_new_product';
	}

	public function rules()
	{
		return array(
			array('sale_return_header_id, delivery_new_product_id', 'required'),
			array('quantity, sale_return_header_id, delivery_new_product_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, quantity, unit_price, sale_return_header_id, delivery_new_product_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'saleReturnHeader' => array(self::BELONGS_TO, 'SaleReturnHeader', 'sale_return_header_id'),
			'deliveryNewProduct' => array(self::BELONGS_TO, 'DeliveryNewProduct', 'delivery_new_product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'sale_return_header_id' => 'Sale Return Header',
			'delivery_new_product_id' => 'Delivery New Product',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('quantity', $this->quantity);
		$criteria->compare('unit_price', $this->unit_price, true);
		$criteria->compare('sale_return_header_id', $this->sale_return_header_id);
		$criteria->compare('delivery_new_product_id', $this->delivery_new_product_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}