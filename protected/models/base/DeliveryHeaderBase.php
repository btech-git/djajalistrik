<?php

/**
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $note
 * @property integer $order_header_id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property integer $packing_list_header_id
 * @property string $note_internal
 *
 * @property DeliveryDetail[] $deliveryDetails
 * @property PackingListHeader $packingListHeader
 * @property OrderHeader $orderHeader
 * @property Branch $branch
 * @property Admin $admin
 * @property Warehouse $warehouse
 * @property DeliveryNewProduct[] $deliveryNewProducts
 * @property Invoice[] $invoices
 * @property SaleReturnHeader[] $saleReturnHeaders
 */
class DeliveryHeaderBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_delivery_header';
    }

    public function rules() {
        return array(
            array('number, date, order_header_id, warehouse_id, branch_id, admin_id', 'required'),
            array('order_header_id, warehouse_id, branch_id, admin_id, is_inactive, packing_list_header_id', 'numerical', 'integerOnly' => true),
            array('number', 'length', 'max' => 60),
            array('note, note_internal', 'safe'),
            // The following rule is used by search().
            array('id, number, date, note, order_header_id, warehouse_id, branch_id, admin_id, is_inactive, packing_list_header_id, note_internal', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryDetails' => array(self::HAS_MANY, 'DeliveryDetail', 'delivery_header_id'),
            'packingListHeader' => array(self::BELONGS_TO, 'PackingListHeader', 'packing_list_header_id'),
            'orderHeader' => array(self::BELONGS_TO, 'OrderHeader', 'order_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'deliveryNewProducts' => array(self::HAS_MANY, 'DeliveryNewProduct', 'delivery_header_id'),
            'invoices' => array(self::HAS_MANY, 'Invoice', 'delivery_header_id'),
            'saleReturnHeaders' => array(self::HAS_MANY, 'SaleReturnHeader', 'delivery_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'note' => 'Note',
            'order_header_id' => 'Order Header',
            'warehouse_id' => 'Warehouse',
            'branch_id' => 'Branch',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
            'packing_list_header_id' => 'Packing List Header',
            'note_internal' => 'Note Internal',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.order_header_id', $this->order_header_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.packing_list_header_id', $this->packing_list_header_id);
        $criteria->compare('t.note_internal', $this->note_internal, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
