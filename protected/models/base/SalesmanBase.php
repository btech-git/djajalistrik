<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $is_inactive
 *
 * @property Customer[] $customers
 */
class SalesmanBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_salesman';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('email', 'email'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>60),
			array('phone', 'length', 'max'=>20),
			array('address', 'safe'),
			// The following rule is used by search().
			array('id, name, address, phone, email, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'customers' => array(self::HAS_MANY, 'Customer', 'salesman_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'address' => 'Address',
			'phone' => 'Phone',
			'email' => 'Email',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}