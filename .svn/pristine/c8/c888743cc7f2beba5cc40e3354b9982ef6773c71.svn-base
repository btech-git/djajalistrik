<?php

/**
 * @property integer $id
 * @property string $name
 * @property integer $product_category_main_id
 * @property integer $is_inactive
 *
 * @property Product[] $products
 * @property Product[] $products1
 * @property ProductCategoryMain $productCategoryMain
 * @property ProductDiscountCategory[] $productDiscountCategories
 */
class ProductCategoryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_product_category';
	}

	public function rules()
	{
		return array(
			array('name, product_category_main_id', 'required'),
			array('product_category_main_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, name, product_category_main_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'products' => array(self::HAS_MANY, 'Product', 'product_category_id_bulk'),
			'products1' => array(self::HAS_MANY, 'Product', 'product_category_id_single'),
			'productCategoryMain' => array(self::BELONGS_TO, 'ProductCategoryMain', 'product_category_main_id'),
			'productDiscountCategories' => array(self::HAS_MANY, 'ProductDiscountCategory', 'product_category_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'product_category_main_id' => 'Product Category Main',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('product_category_main_id', $this->product_category_main_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}