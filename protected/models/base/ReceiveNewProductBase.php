<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property integer $receive_header_id
 * @property integer $purchase_new_product_id
 * @property integer $order_new_product_id
 * @property integer $is_inactive
 * @property integer $quantity_return
 *
 * @property DeliveryNewProduct[] $deliveryNewProducts
 * @property PurchaseReturnNewProduct[] $purchaseReturnNewProducts
 * @property ReceiveHeader $receiveHeader
 * @property PurchaseNewProduct $purchaseNewProduct
 * @property OrderNewProduct $orderNewProduct
 */
class ReceiveNewProductBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_receive_new_product';
    }

    public function rules() {
        return array(
            array('quantity, receive_header_id, purchase_new_product_id, order_new_product_id', 'required'),
            array('quantity, receive_header_id, purchase_new_product_id, is_inactive, quantity_return, order_new_product_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('id, quantity, receive_header_id, purchase_new_product_id, is_inactive, quantity_return, order_new_product_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryNewProducts' => array(self::HAS_MANY, 'DeliveryNewProduct', 'receive_new_product_id'),
            'purchaseReturnNewProducts' => array(self::HAS_MANY, 'PurchaseReturnNewProduct', 'receive_new_product_id'),
            'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
            'purchaseNewProduct' => array(self::BELONGS_TO, 'PurchaseNewProduct', 'purchase_new_product_id'),
            'orderNewProduct' => array(self::BELONGS_TO, 'OrderNewProduct', 'order_new_product_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'receive_header_id' => 'Receive Header',
            'purchase_new_product_id' => 'Purchase New Product',
            'is_inactive' => 'Is Inactive',
            'quantity_return' => 'Quantity Return',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('receive_header_id', $this->receive_header_id);
        $criteria->compare('purchase_new_product_id', $this->purchase_new_product_id);
        $criteria->compare('order_new_product_id', $this->order_new_product_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('quantity_return', $this->quantity_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
