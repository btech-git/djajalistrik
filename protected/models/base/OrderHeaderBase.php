<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $deposit
 * @property string $reference_number
 * @property string $shipping_fee
 * @property integer $tax
 * @property string $note_external
 * @property string $note_internal
 * @property string $admin_edit_list
 * @property integer $customer_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_tax
 * @property integer $is_include
 * @property integer $is_approved
 * @property integer $is_hold
 * @property integer $is_inactive
 * @property string $sub_total
 * @property string $total_detail
 * @property string $total_new_product
 *
 * @property DeliveryHeader[] $deliveryHeaders
 * @property InvoiceHeader[] $invoiceHeaders
 * @property OrderDetail[] $orderDetails
 * @property Branch $branch
 * @property Admin $admin
 * @property Customer $customer
 * @property OrderNewProduct[] $orderNewProducts
 * @property PackingListHeader[] $packingListHeaders
 * @property PurchaseHeader[] $purchaseHeaders
 */
class OrderHeaderBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_order_header';
    }

    public function rules() {
        return array(
            array('number, date, customer_id, branch_id, admin_id', 'required'),
            array('tax, customer_id, branch_id, admin_id, is_tax, is_include, is_approved, is_hold, is_inactive', 'numerical', 'integerOnly' => true),
            array('number, reference_number, admin_edit_list', 'length', 'max' => 60),
            array('deposit, shipping_fee, sub_total, total_detail, total_new_product', 'length', 'max' => 18),
            array('note_external, note_internal', 'safe'),
            // The following rule is used by search().
            array('id, number, date, deposit, reference_number, shipping_fee, sub_total, total_detail, total_new_product, tax, note_external, note_internal, admin_edit_list, customer_id, branch_id, admin_id, is_tax, is_include, is_approved, is_hold, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'order_header_id'),
            'invoiceHeaders' => array(self::HAS_MANY, 'InvoiceHeader', 'order_header_id'),
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'order_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'orderNewProducts' => array(self::HAS_MANY, 'OrderNewProduct', 'order_header_id'),
            'packingListHeaders' => array(self::HAS_MANY, 'PackingListHeader', 'order_header_id'),
            'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'order_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'deposit' => 'Deposit',
            'reference_number' => 'Reference Number',
            'shipping_fee' => 'Shipping Fee',
            'tax' => 'Tax',
            'note_external' => 'Note External',
            'note_internal' => 'Note Internal',
            'admin_edit_list' => 'Admin Edit List',
            'customer_id' => 'Customer',
            'branch_id' => 'Branch',
            'admin_id' => 'Admin',
            'is_tax' => 'Is Tax',
            'is_include' => 'Is Include',
            'is_approved' => 'Is Approved',
            'is_hold' => 'Is Hold',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('deposit', $this->deposit, true);
        $criteria->compare('reference_number', $this->reference_number, true);
        $criteria->compare('shipping_fee', $this->shipping_fee, true);
        $criteria->compare('tax', $this->tax);
        $criteria->compare('note_external', $this->note_external, true);
        $criteria->compare('note_internal', $this->note_internal, true);
        $criteria->compare('admin_edit_list', $this->admin_edit_list, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('is_tax', $this->is_tax);
        $criteria->compare('is_include', $this->is_include);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('is_hold', $this->is_hold);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
