<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property string $total_invoice
 * @property string $delivery_date
 * @property integer $customer_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $delivery_address
 *
 * @property SaleReceiptDetail[] $saleReceiptDetails
 * @property Branch $branch
 * @property Admin $admin
 * @property Customer $customer
 */
class SaleReceiptHeaderBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_sale_receipt_header';
    }

    public function rules() {
        return array(
            array('number, date, customer_id, branch_id, admin_id', 'required'),
            array('customer_id, branch_id, admin_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('number', 'length', 'max' => 60),
            array('total_invoice', 'length', 'max' => 18),
            array('note, delivery_date, delivery_address', 'safe'),
            // The following rule is used by search().
            array('id, number, date, note, total_invoice, delivery_date, customer_id, branch_id, admin_id, is_inactive, delivery_address', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'saleReceiptDetails' => array(self::HAS_MANY, 'SaleReceiptDetail', 'sale_receipt_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'note' => 'Note',
            'total_invoice' => 'Total Invoice',
            'delivery_date' => 'Delivery Date',
            'customer_id' => 'Customer',
            'branch_id' => 'Branch',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
            'delivery_address' => 'Delivery Address',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('total_invoice', $this->total_invoice, true);
        $criteria->compare('delivery_date', $this->delivery_date, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('delivery_address', $this->delivery_address, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
