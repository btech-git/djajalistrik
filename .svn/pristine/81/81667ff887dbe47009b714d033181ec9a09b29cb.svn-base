<?php

/**
 * @property integer $id
 * @property integer $purchase_receipt_header_id
 * @property integer $is_inactive
 * @property string $amount
 * @property integer $receive_header_id
 * @property string $tax_number
 * @property string $invoice_number
 *
 * @property ReceiveHeader $receiveHeader
 * @property PurchaseReceiptHeader $purchaseReceiptHeader
 */
class PurchaseReceiptDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_purchase_receipt_detail';
    }

    public function rules() {
        return array(
            array('purchase_receipt_header_id, receive_header_id', 'required'),
            array('purchase_receipt_header_id, is_inactive, receive_header_id', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            array('tax_number, invoice_number', 'length', 'max' => 20),
            // The following rule is used by search().
            array('id, purchase_receipt_header_id, is_inactive, amount, receive_header_id, tax_number, invoice_number', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
            'purchaseReceiptHeader' => array(self::BELONGS_TO, 'PurchaseReceiptHeader', 'purchase_receipt_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'purchase_receipt_header_id' => 'Purchase Receipt Header',
            'is_inactive' => 'Is Inactive',
            'amount' => 'Amount',
            'receive_header_id' => 'Receive Header',
            'tax_number' => 'Faktur Pajak #',
            'invoice_number' => 'Invoice #'
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('purchase_receipt_header_id', $this->purchase_receipt_header_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('receive_header_id', $this->receive_header_id);
        $criteria->compare('tax_number', $this->tax_number, true);
        $criteria->compare('invoice_number', $this->tax_number, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
