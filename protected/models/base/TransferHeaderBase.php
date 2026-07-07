<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $warehouse_id_from
 * @property integer $warehouse_id_to
 * @property integer $admin_id
 * @property integer $branch_id
 * @property integer $is_inactive
 *
 * @property TransferDetail[] $transferDetails
 * @property Admin $admin
 * @property Branch $branch
 * @property Warehouse $warehouseIdFrom
 * @property Warehouse $warehouseIdTo
 */
class TransferHeaderBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_transfer_header';
	}

	public function rules()
	{
		return array(
			array('number, date, warehouse_id_from, warehouse_id_to, admin_id, branch_id', 'required'),
			array('warehouse_id_from, warehouse_id_to, admin_id, branch_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>60),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, number, date, note, warehouse_id_from, warehouse_id_to, admin_id, branch_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'transfer_header_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'warehouseIdFrom' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id_from'),
			'warehouseIdTo' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id_to'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'date' => 'Date',
			'note' => 'Note',
			'warehouse_id_from' => 'Warehouse Id From',
			'warehouse_id_to' => 'Warehouse Id To',
			'admin_id' => 'Admin',
			'branch_id' => 'Branch',
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
		$criteria->compare('t.warehouse_id_from', $this->warehouse_id_from);
		$criteria->compare('t.warehouse_id_to', $this->warehouse_id_to);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.branch_id', $this->branch_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}