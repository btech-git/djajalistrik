<?php

/**
 * @property integer $id
 * @property integer $quantity_order
 * @property integer $quantity_receive
 * @property integer $receive_header_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $is_inactive
 * @property integer $purchase_detail_id
 * @property integer $quantity_return
 *
 * @property PurchaseReturnDetail[] $purchaseReturnDetails
 * @property PurchaseDetail $purchaseDetail
 * @property ReceiveHeader $receiveHeader
 * @property Product $product
 * @property Unit $unit
 */
class ReceiveDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_receive_detail';
    }

    public function rules() {
        return array(
            array('receive_header_id, product_id, unit_id, purchase_detail_id', 'required'),
            array('quantity_order, quantity_receive, receive_header_id, product_id, unit_id, is_inactive, purchase_detail_id, quantity_return', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('id, quantity_order, quantity_receive, receive_header_id, product_id, unit_id, is_inactive, purchase_detail_id, quantity_return', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseReturnDetails' => array(self::HAS_MANY, 'PurchaseReturnDetail', 'receive_detail_id'),
            'purchaseDetail' => array(self::BELONGS_TO, 'PurchaseDetail', 'purchase_detail_id'),
            'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity_order' => 'Quantity Order',
            'quantity_receive' => 'Quantity Receive',
            'receive_header_id' => 'Receive Header',
            'product_id' => 'Product',
            'unit_id' => 'Unit',
            'is_inactive' => 'Is Inactive',
            'purchase_detail_id' => 'Purchase Detail',
            'quantity_return' => 'Quantity Return',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('quantity_order', $this->quantity_order);
        $criteria->compare('quantity_receive', $this->quantity_receive);
        $criteria->compare('receive_header_id', $this->receive_header_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('purchase_detail_id', $this->purchase_detail_id);
        $criteria->compare('quantity_return', $this->quantity_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
