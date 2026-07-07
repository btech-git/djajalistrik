<?php

/**
 * @property integer $id
 * @property integer $quantity_current
 * @property integer $quantity_adjustment
 * @property integer $adjustment_header_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $is_inactive
 *
 * @property Unit $unit
 * @property AdjustmentHeader $adjustmentHeader
 * @property Product $product
 */
class AdjustmentDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_adjustment_detail';
	}

	public function rules()
	{
		return array(
			array('adjustment_header_id, product_id, unit_id', 'required'),
			array('quantity_current, quantity_adjustment, adjustment_header_id, product_id, unit_id, is_inactive', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, quantity_current, quantity_adjustment, adjustment_header_id, product_id, unit_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
			'adjustmentHeader' => array(self::BELONGS_TO, 'AdjustmentHeader', 'adjustment_header_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity_current' => 'Quantity Current',
			'quantity_adjustment' => 'Quantity Adjustment',
			'adjustment_header_id' => 'Adjustment Header',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('quantity_current', $this->quantity_current);
		$criteria->compare('quantity_adjustment', $this->quantity_adjustment);
		$criteria->compare('adjustment_header_id', $this->adjustment_header_id);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('unit_id', $this->unit_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}