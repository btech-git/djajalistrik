<?php

/**
 * @property integer $id
 * @property string $product_name
 * @property integer $quantity
 * @property string $unit_price
 * @property string $discount_1
 * @property string $discount_2
 * @property string $discount_3
 * @property string $discount_4
 * @property string $discount_5
 * @property string $quotation_value
 * @property integer $quotation_header_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $is_inactive
 *
 * @property Unit $unit
 * @property QuotationHeader $quotationHeader
 * @property Product $product
 */
class QuotationDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_quotation_detail';
	}

	public function rules()
	{
		return array(
			array('product_name, quotation_header_id', 'required'),
			array('quantity, quotation_header_id, product_id, unit_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('product_name', 'length', 'max'=>60),
			array('unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, quotation_value', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, product_name, quantity, unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, quotation_value, quotation_header_id, product_id, unit_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
			'quotationHeader' => array(self::BELONGS_TO, 'QuotationHeader', 'quotation_header_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_name' => 'Product Name',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'discount_1' => 'Discount 1',
			'discount_2' => 'Discount 2',
			'discount_3' => 'Discount 3',
			'discount_4' => 'Discount 4',
			'discount_5' => 'Discount 5',
			'quotation_value' => 'Quotation Value',
			'quotation_header_id' => 'Quotation Header',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('product_name', $this->product_name, true);
		$criteria->compare('quantity', $this->quantity);
		$criteria->compare('unit_price', $this->unit_price, true);
		$criteria->compare('discount_1', $this->discount_1, true);
		$criteria->compare('discount_2', $this->discount_2, true);
		$criteria->compare('discount_3', $this->discount_3, true);
		$criteria->compare('discount_4', $this->discount_4, true);
		$criteria->compare('discount_5', $this->discount_5, true);
		$criteria->compare('quotation_value', $this->quotation_value, true);
		$criteria->compare('quotation_header_id', $this->quotation_header_id);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('unit_id', $this->unit_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}