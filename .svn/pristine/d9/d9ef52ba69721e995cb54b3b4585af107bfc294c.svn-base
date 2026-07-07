<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $rate
 * @property integer $is_inactive
 *
 * @property PurchaseHeader[] $purchaseHeaders
 */
class CurrencyBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_currency';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('rate', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, name, rate, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'currency_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'rate' => 'Rate',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('rate', $this->rate, true);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}