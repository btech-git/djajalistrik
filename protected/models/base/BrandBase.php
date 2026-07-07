<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $is_inactive
 *
 * @property Product[] $products
 * @property PurchaseNewProduct[] $purchaseNewProducts
 */
class BrandBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_brand';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('description', 'safe'),
			// The following rule is used by search().
			array('id, name, description, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'products' => array(self::HAS_MANY, 'Product', 'brand_id'),
			'purchaseNewProducts' => array(self::HAS_MANY, 'PurchaseNewProduct', 'brand_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}