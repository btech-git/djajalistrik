<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $account_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property ExpenseDetail[] $expenseDetails
 * @property Account $account
 * @property Branch $branch
 * @property Admin $admin
 */
class ExpenseHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_expense_header';
	}

	public function rules()
	{
		return array(
			array('number, date, account_id, branch_id, admin_id', 'required'),
			array('account_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, account_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'expenseDetails' => array(self::HAS_MANY, 'ExpenseDetail', 'expense_header_id'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'note' => 'Note',
			'account_id' => 'Account',
			'branch_id' => 'Branch',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.number', $this->number, true);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('t.note', $this->note, true);
		$criteria->compare('t.account_id', $this->account_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}