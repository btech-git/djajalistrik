<?php

/**
 * @property integer $id
 * @property integer $volume
 * @property string $selling_price
 * @property integer $quantity_minimum
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $product_group_id
 * @property integer $product_category_id
 * @property integer $is_inactive
 *
 * @property ProductCategory $productCategory
 * @property Product $product
 * @property Unit $unit
 * @property ProductGroup $productGroup
 */
class ProductUnitBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_product_unit';
	}

	public function rules()
	{
		return array(
			array('volume, product_id, unit_id, product_group_id, product_category_id', 'required'),
			array('volume, quantity_minimum, product_id, unit_id, product_group_id, product_category_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('selling_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, volume, selling_price, quantity_minimum, product_id, unit_id, product_group_id, product_category_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
			'productGroup' => array(self::BELONGS_TO, 'ProductGroup', 'product_group_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'volume' => 'Volume',
			'selling_price' => 'Selling Price',
			'quantity_minimum' => 'Quantity Minimum',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'product_group_id' => 'Product Group',
			'product_category_id' => 'Product Category',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('volume', $this->volume);
		$criteria->compare('selling_price', $this->selling_price, true);
		$criteria->compare('quantity_minimum', $this->quantity_minimum);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('unit_id', $this->unit_id);
		$criteria->compare('product_group_id', $this->product_group_id);
		$criteria->compare('product_category_id', $this->product_category_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}