<?php

/**
 * @property integer $id
 * @property string $amount
 * @property string $total_invoice
 * @property string $additional_amount
 * @property string $memo
 * @property integer $sale_payment_header_id
 * @property integer $payment_type_id
 * @property integer $is_inactive
 * @property integer $invoice_header_id
 *
 * @property SalePaymentHeader $salePaymentHeader
 * @property PaymentType $paymentType
 * @property InvoiceHeader $invoiceHeader
 */
class SalePaymentDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_sale_payment_detail';
    }

    public function rules() {
        return array(
            array('sale_payment_header_id, payment_type_id, invoice_header_id', 'required'),
            array('sale_payment_header_id, payment_type_id, is_inactive, invoice_header_id', 'numerical', 'integerOnly' => true),
            array('amount, additional_amount, total_invoice', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 60),
            // The following rule is used by search().
            array('id, amount, memo, sale_payment_header_id, payment_type_id, is_inactive, invoice_header_id, additional_amount, total_invoice', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'salePaymentHeader' => array(self::BELONGS_TO, 'SalePaymentHeader', 'sale_payment_header_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
            'invoiceHeader' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'amount' => 'Amount',
            'memo' => 'Memo',
            'sale_payment_header_id' => 'Sale Payment Header',
            'payment_type_id' => 'Payment Type',
            'invoice_header_id' => 'Invoice',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('sale_payment_header_id', $this->sale_payment_header_id);
        $criteria->compare('payment_type_id', $this->payment_type_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('invoice_header_id', $this->invoice_header_id);
        $criteria->compare('additional_amount', $this->additional_amount, true);
        $criteria->compare('total_invoice', $this->total_invoice, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
