<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $tax
 * @property string $grand_total
 * @property string $payment_total
 * @property string $note_external
 * @property string $note_internal
 * @property integer $order_header_id
 * @property integer $supplier_id
 * @property integer $customer_id
 * @property integer $currency_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property string $admin_edit_list
 * @property integer $is_tax
 * @property integer $is_include
 * @property integer $is_approved
 * @property integer $is_hold
 * @property integer $is_inactive
 *
 * @property PurchaseDetail[] $purchaseDetails
 * @property Currency $currency
 * @property Branch $branch
 * @property Admin $admin
 * @property OrderHeader $orderHeader
 * @property Supplier $supplier
 * @property Customer $customer
 * @property PurchaseNewProduct[] $purchaseNewProducts
 * @property ReceiveHeader[] $receiveHeaders
 */
class PurchaseHeaderBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_purchase_header';
    }

    public function rules() {
        return array(
            array('number, date, supplier_id, currency_id, branch_id, admin_id', 'required'),
            array('order_header_id, supplier_id, customer_id, currency_id, branch_id, admin_id, is_tax, is_include, is_approved, is_hold, is_inactive', 'numerical', 'integerOnly' => true),
            array('number, admin_edit_list', 'length', 'max' => 60),
            array('tax', 'length', 'max' => 10),
            array('grand_total, payment_total', 'length', 'max' => 18),
            array('note_external, note_internal', 'safe'),
            // The following rule is used by search().
            array('id, number, date, tax, grand_total, payment_total, note_external, note_internal, order_header_id, supplier_id, customer_id, currency_id, branch_id, admin_id, admin_edit_list, is_tax, is_include, is_approved, is_hold, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseDetails' => array(self::HAS_MANY, 'PurchaseDetail', 'purchase_header_id'),
            'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'orderHeader' => array(self::BELONGS_TO, 'OrderHeader', 'order_header_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'purchaseNewProducts' => array(self::HAS_MANY, 'PurchaseNewProduct', 'purchase_header_id'),
            'receiveHeaders' => array(self::HAS_MANY, 'ReceiveHeader', 'purchase_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'tax' => 'Tax',
            'grand_total' => 'Grand Total',
            'payment_total' => 'Payment Total',
            'note_external' => 'Note External',
            'note_internal' => 'Note Internal',
            'order_header_id' => 'Order Header',
            'supplier_id' => 'Supplier',
            'customer_id' => 'Customer',
            'currency_id' => 'Currency',
            'branch_id' => 'Branch',
            'admin_id' => 'Admin',
            'admin_edit_list' => 'Admin Edit List',
            'is_tax' => 'Is Tax',
            'is_include' => 'Is Include',
            'is_approved' => 'Is Approved',
            'is_hold' => 'Is Hold',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.tax', $this->tax, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.payment_total', $this->payment_total, true);
        $criteria->compare('t.note_external', $this->note_external, true);
        $criteria->compare('t.note_internal', $this->note_internal, true);
        $criteria->compare('t.order_header_id', $this->order_header_id);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.currency_id', $this->currency_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.admin_edit_list', $this->admin_edit_list, true);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_include', $this->is_include);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.is_hold', $this->is_hold);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
