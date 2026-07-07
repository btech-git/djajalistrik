<?php

/**
 * @property integer $id
 * @property string $value_1
 * @property string $value_2
 * @property string $value_3
 * @property string $value_4
 * @property string $value_5
 * @property string $quotation_value
 * @property integer $discount_category_id
 * @property integer $product_category_id
 * @property integer $is_inactive
 *
 * @property DiscountCategory $discountCategory
 * @property ProductCategory $productCategory
 */
class ProductDiscountCategoryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_product_discount_category';
	}

	public function rules()
	{
		return array(
			array('discount_category_id, product_category_id', 'required'),
			array('discount_category_id, product_category_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('value_1, value_2, value_3, value_4, value_5, quotation_value', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, value_1, value_2, value_3, value_4, value_5, quotation_value, discount_category_id, product_category_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'discountCategory' => array(self::BELONGS_TO, 'DiscountCategory', 'discount_category_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'value_1' => 'Value 1',
			'value_2' => 'Value 2',
			'value_3' => 'Value 3',
			'value_4' => 'Value 4',
			'value_5' => 'Value 5',
			'quotation_value' => 'Quotation Value',
			'discount_category_id' => 'Discount Category',
			'product_category_id' => 'Product Category',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('value_1', $this->value_1, true);
		$criteria->compare('value_2', $this->value_2, true);
		$criteria->compare('value_3', $this->value_3, true);
		$criteria->compare('value_4', $this->value_4, true);
		$criteria->compare('value_5', $this->value_5, true);
		$criteria->compare('quotation_value', $this->quotation_value, true);
		$criteria->compare('discount_category_id', $this->discount_category_id);
		$criteria->compare('product_category_id', $this->product_category_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}