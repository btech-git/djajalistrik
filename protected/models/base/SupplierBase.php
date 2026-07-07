<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $company
 * @property string $address
 * @property string $city
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $credit_limit
 * @property string $product_type
 * @property integer $is_inactive
 *
 * @property PurchaseHeader[] $purchaseHeaders
 * @property PurchaseReceiptHeader[] $purchaseReceiptHeaders
 */
class SupplierBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_supplier';
	}

	public function rules()
	{
		return array(
			array('name, credit_limit, product_type', 'required'),
			array('email', 'email'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name, company, city, phone, fax, email, website, product_type', 'length', 'max'=>60),
			array('credit_limit', 'length', 'max'=>18),
			array('address', 'safe'),
			// The following rule is used by search().
			array('id, name, company, address, city, phone, fax, email, website, credit_limit, product_type, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'supplier_id'),
			'purchaseReceiptHeaders' => array(self::HAS_MANY, 'PurchaseReceiptHeader', 'supplier_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'company' => 'Company',
			'address' => 'Address',
			'city' => 'City',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'email' => 'Email',
			'website' => 'Website',
			'credit_limit' => 'Credit Limit',
			'product_type' => 'Product Type',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('company', $this->company, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('city', $this->city, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('fax', $this->fax, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('website', $this->website, true);
		$criteria->compare('credit_limit', $this->credit_limit, true);
		$criteria->compare('product_type', $this->product_type, true);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}