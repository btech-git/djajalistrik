<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $unit_price
 * @property string $discount_1
 * @property string $discount_2
 * @property string $discount_3
 * @property string $discount_4
 * @property string $discount_5
 * @property integer $purchase_header_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $is_inactive
 * @property integer $quantity_receive
 * @property integer $quantity_remaining
 * @property integer $order_detail_id
 * @property string $unit_price_sale_order
 * @property string $unit_price_after_discount
 * @property integer $quantity_return
 *
 * @property OrderDetail $orderDetail
 * @property PurchaseHeader $purchaseHeader
 * @property Product $product
 * @property Unit $unit
 * @property ReceiveDetail[] $receiveDetails
 */
class PurchaseDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_purchase_detail';
    }

    public function rules() {
        return array(
            array('purchase_header_id, product_id', 'required'),
            array('quantity, purchase_header_id, product_id, unit_id, is_inactive, quantity_receive, quantity_remaining, order_detail_id, quantity_return', 'numerical', 'integerOnly' => true),
            array('unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, unit_price_sale_order, unit_price_after_discount', 'length', 'max' => 18),
            // The following rule is used by search().
            array('id, quantity, unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, purchase_header_id, product_id, unit_id, is_inactive, quantity_receive, quantity_remaining, order_detail_id, unit_price_sale_order, unit_price_after_discount, quantity_return', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'orderDetail' => array(self::BELONGS_TO, 'OrderDetail', 'order_detail_id'),
            'purchaseHeader' => array(self::BELONGS_TO, 'PurchaseHeader', 'purchase_header_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'purchase_detail_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'discount_1' => 'Discount 1',
            'discount_2' => 'Discount 2',
            'discount_3' => 'Discount 3',
            'discount_4' => 'Discount 4',
            'discount_5' => 'Discount 5',
            'purchase_header_id' => 'Purchase Header',
            'product_id' => 'Product',
            'unit_id' => 'Unit',
            'is_inactive' => 'Is Inactive',
            'quantity_receive' => 'Quantity Receive',
            'quantity_remaining' => 'Quantity Remaining',
            'order_detail_id' => 'Order Detail',
            'unit_price_sale_order' => 'Unit Price Sale Order',
            'unit_price_after_discount' => 'Unit Price After Discount',
            'quantity_return' => 'Quantity Return',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('discount_1', $this->discount_1, true);
        $criteria->compare('discount_2', $this->discount_2, true);
        $criteria->compare('discount_3', $this->discount_3, true);
        $criteria->compare('discount_4', $this->discount_4, true);
        $criteria->compare('discount_5', $this->discount_5, true);
        $criteria->compare('purchase_header_id', $this->purchase_header_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('quantity_receive', $this->quantity_receive);
        $criteria->compare('quantity_remaining', $this->quantity_remaining);
        $criteria->compare('order_detail_id', $this->order_detail_id);
        $criteria->compare('unit_price_sale_order', $this->unit_price_sale_order, true);
        $criteria->compare('unit_price_after_discount', $this->unit_price_after_discount, true);
        $criteria->compare('quantity_return', $this->quantity_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
