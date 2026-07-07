<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property AdjustmentDetail[] $adjustmentDetails
 * @property Branch $branch
 * @property Admin $admin
 * @property Warehouse $warehouse
 */
class AdjustmentHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_adjustment_header';
	}

	public function rules()
	{
		return array(
			array('number, date, warehouse_id, branch_id, admin_id', 'required'),
			array('warehouse_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, warehouse_id, branch_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'adjustmentDetails' => array(self::HAS_MANY, 'AdjustmentDetail', 'adjustment_header_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'note' => 'Note',
			'warehouse_id' => 'Warehouse',
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
		$criteria->compare('t.warehouse_id', $this->warehouse_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}