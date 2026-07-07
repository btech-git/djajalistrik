<?php

/**
 * @property integer $id
 * @property integer $receipt_temporary_header_id
 * @property integer $invoice_temporary_id
 * @property integer $is_inactive
 *
 * @property InvoiceTemporary $invoiceTemporary
 * @property ReceiptTemporaryHeader $receiptTemporaryHeader
 */
class ReceiptTemporaryDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_receipt_temporary_detail';
	}

	public function rules()
	{
		return array(
			array('receipt_temporary_header_id, invoice_temporary_id', 'required'),
			array('receipt_temporary_header_id, invoice_temporary_id, is_inactive', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, receipt_temporary_header_id, invoice_temporary_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'invoiceTemporary' => array(self::BELONGS_TO, 'InvoiceTemporary', 'invoice_temporary_id'),
			'receiptTemporaryHeader' => array(self::BELONGS_TO, 'ReceiptTemporaryHeader', 'receipt_temporary_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'receipt_temporary_header_id' => 'Receipt Temporary Header',
			'invoice_temporary_id' => 'Invoice Temporary',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('receipt_temporary_header_id', $this->receipt_temporary_header_id);
		$criteria->compare('invoice_temporary_id', $this->invoice_temporary_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}