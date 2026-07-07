<?php

/**
 * @property integer $id
 * @property integer $sale_receipt_header_id
 * @property integer $invoice_header_id
 * @property integer $is_inactive
 * @property string $invoice_amount
 *
 * @property InvoiceHeader $invoiceHeader
 * @property SaleReceiptHeader $saleReceiptHeader
 */
class SaleReceiptDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_sale_receipt_detail';
    }

    public function rules() {
        return array(
            array('sale_receipt_header_id, invoice_header_id', 'required'),
            array('sale_receipt_header_id, invoice_header_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('invoice_amount', 'length', 'max' => 18),
            // The following rule is used by search().
            array('id, sale_receipt_header_id, invoice_header_id, is_inactive, invoice_amount', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'invoiceHeader' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_header_id'),
            'saleReceiptHeader' => array(self::BELONGS_TO, 'SaleReceiptHeader', 'sale_receipt_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sale_receipt_header_id' => 'Sale Receipt Header',
            'invoice_header_id' => 'Invoice Header',
            'is_inactive' => 'Is Inactive',
            'invoice_amount' => 'Invoice Amount',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('sale_receipt_header_id', $this->sale_receipt_header_id);
        $criteria->compare('invoice_header_id', $this->invoice_header_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('invoice_amount', $this->invoice_amount, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
