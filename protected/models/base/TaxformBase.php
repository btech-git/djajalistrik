<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property string $cn_constant
 * @property integer $invoice_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property Invoice $invoice
 * @property Branch $branch
 * @property Admin $admin
 */
class TaxformBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_taxform';
	}

	public function rules()
	{
		return array(
			array('cn_constant, invoice_id, branch_id, admin_id', 'required'),
			array('cn_ordinal, invoice_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('cn_constant', 'length', 'max'=>20),
			// The following rule is used by search().
			array('id, cn_ordinal, cn_constant, invoice_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'invoice' => array(self::BELONGS_TO, 'Invoice', 'invoice_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cn_ordinal' => 'Cn Ordinal',
			'cn_constant' => 'Cn Constant',
			'invoice_id' => 'Invoice',
			'branch_id' => 'Branch',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('cn_ordinal', $this->cn_ordinal);
		$criteria->compare('cn_constant', $this->cn_constant, true);
		$criteria->compare('invoice_id', $this->invoice_id);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('admin_id', $this->admin_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}