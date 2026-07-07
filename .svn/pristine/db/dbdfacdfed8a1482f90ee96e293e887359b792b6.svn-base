<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property string $grand_total
 * @property string $payment_total
 * @property integer $supplier_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property PurchasePaymentHeader[] $purchasePaymentHeaders
 * @property PurchaseReceiptDetail[] $purchaseReceiptDetails
 * @property Branch $branch
 * @property Admin $admin
 * @property Supplier $supplier
 */
class PurchaseReceiptHeaderBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_purchase_receipt_header';
    }

    public function rules() {
        return array(
            array('number, date, supplier_id, branch_id, admin_id', 'required'),
            array('supplier_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('number', 'length', 'max' => 60),
            array('grand_total, payment_total', 'length', 'max' => 18),
            array('note', 'safe'),
            // The following rule is used by search().
            array('id, number, date, note, grand_total, payment_total, supplier_id, branch_id, admin_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchasePaymentHeaders' => array(self::HAS_MANY, 'PurchasePaymentHeader', 'purchase_receipt_header_id'),
            'purchaseReceiptDetails' => array(self::HAS_MANY, 'PurchaseReceiptDetail', 'purchase_receipt_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'note' => 'Note',
            'grand_total' => 'Grand Total',
            'payment_total' => 'Payment Total',
            'supplier_id' => 'Supplier',
            'branch_id' => 'Branch',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.payment_total', $this->payment_total, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
