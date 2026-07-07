<?php

/**
 * @property integer $id
 * @property string $description
 * @property string $amount
 * @property string $memo
 * @property integer $deposit_header_id
 * @property integer $is_inactive
 *
 * @property DepositHeader $depositHeader
 */
class DepositDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_deposit_detail';
	}

	public function rules()
	{
		return array(
			array('description, deposit_header_id', 'required'),
			array('deposit_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('description, memo', 'length', 'max'=>60),
			array('amount', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, description, amount, memo, deposit_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'depositHeader' => array(self::BELONGS_TO, 'DepositHeader', 'deposit_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => 'Description',
			'amount' => 'Amount',
			'memo' => 'Memo',
			'deposit_header_id' => 'Deposit Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('amount', $this->amount, true);
		$criteria->compare('memo', $this->memo, true);
		$criteria->compare('deposit_header_id', $this->deposit_header_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}