<?php

/**
 * @property integer $id
 * @property string $amount
 * @property string $memo
 * @property integer $purchase_payment_header_id
 * @property integer $payment_type_id
 * @property integer $is_inactive
 *
 * @property PurchasePaymentHeader $purchasePaymentHeader
 * @property PaymentType $paymentType
 */
class PurchasePaymentDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_purchase_payment_detail';
	}

	public function rules()
	{
		return array(
			array('purchase_payment_header_id, payment_type_id', 'required'),
			array('purchase_payment_header_id, payment_type_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>18),
			array('memo', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, amount, memo, purchase_payment_header_id, payment_type_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchasePaymentHeader' => array(self::BELONGS_TO, 'PurchasePaymentHeader', 'purchase_payment_header_id'),
			'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'memo' => 'Memo',
			'purchase_payment_header_id' => 'Purchase Payment Header',
			'payment_type_id' => 'Payment Type',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('amount', $this->amount, true);
		$criteria->compare('memo', $this->memo, true);
		$criteria->compare('purchase_payment_header_id', $this->purchase_payment_header_id);
		$criteria->compare('payment_type_id', $this->payment_type_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}