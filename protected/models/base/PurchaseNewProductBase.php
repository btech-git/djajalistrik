<?php

/**
 * @property integer $id
 * @property string $product_code
 * @property string $product_name
 * @property integer $quantity
 * @property string $unit_price
 * @property string $discount_1
 * @property string $discount_2
 * @property string $discount_3
 * @property string $discount_4
 * @property string $discount_5
 * @property integer $purchase_header_id
 * @property integer $product_classification_id
 * @property integer $order_new_product_id
 * @property integer $unit_id
 * @property integer $brand_id
 * @property integer $is_inactive
 * @property integer $quantity_receive
 * @property integer $quantity_remaining
 * @property string $unit_price_sale_order
 * @property string $unit_price_after_discount
 * @property integer $quantity_return
 *
 * @property PurchaseHeader $purchaseHeader
 * @property Unit $unit
 * @property Brand $brand
 * @property ProductClassification $productClassification
 * @property OrderNewProduct $orderNewProduct
 * @property ReceiveNewProduct[] $receiveNewProducts
 */
class PurchaseNewProductBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_purchase_new_product';
    }

    public function rules() {
        return array(
            array('product_name, purchase_header_id', 'required'),
            array('quantity, purchase_header_id, product_classification_id, order_new_product_id, unit_id, brand_id, is_inactive, quantity_receive, quantity_remaining, quantity_return', 'numerical', 'integerOnly' => true),
            array('product_code', 'length', 'max' => 60),
            array('product_name', 'length', 'max' => 300),
            array('unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, unit_price_sale_order, unit_price_after_discount', 'length', 'max' => 18),
            // The following rule is used by search().
            array('id, product_code, product_name, quantity, unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, purchase_header_id, product_classification_id, order_new_product_id, unit_id, brand_id, is_inactive, quantity_receive, quantity_remaining, unit_price_sale_order, unit_price_after_discount, quantity_return', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseHeader' => array(self::BELONGS_TO, 'PurchaseHeader', 'purchase_header_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'productClassification' => array(self::BELONGS_TO, 'ProductClassification', 'product_classification_id'),
            'orderNewProduct' => array(self::BELONGS_TO, 'OrderNewProduct', 'order_new_product_id'),
            'receiveNewProducts' => array(self::HAS_MANY, 'ReceiveNewProduct', 'purchase_new_product_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'discount_1' => 'Discount 1',
            'discount_2' => 'Discount 2',
            'discount_3' => 'Discount 3',
            'discount_4' => 'Discount 4',
            'discount_5' => 'Discount 5',
            'purchase_header_id' => 'Purchase Header',
            'product_classification_id' => 'Product Classification',
            'order_new_product_id' => 'Order New Product',
            'unit_id' => 'Unit',
            'brand_id' => 'Brand',
            'is_inactive' => 'Is Inactive',
            'quantity_receive' => 'Quantity Receive',
            'quantity_remaining' => 'Quantity Remaining',
            'unit_price_sale_order' => 'Unit Price Sale Order',
            'unit_price_after_discount' => 'Unit Price After Discount',
            'quantity_return' => 'Quantity Return',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_code', $this->product_code, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('discount_1', $this->discount_1, true);
        $criteria->compare('discount_2', $this->discount_2, true);
        $criteria->compare('discount_3', $this->discount_3, true);
        $criteria->compare('discount_4', $this->discount_4, true);
        $criteria->compare('discount_5', $this->discount_5, true);
        $criteria->compare('purchase_header_id', $this->purchase_header_id);
        $criteria->compare('product_classification_id', $this->product_classification_id);
        $criteria->compare('order_new_product_id', $this->order_new_product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('quantity_receive', $this->quantity_receive);
        $criteria->compare('quantity_remaining', $this->quantity_remaining);
        $criteria->compare('unit_price_sale_order', $this->unit_price_sale_order, true);
        $criteria->compare('unit_price_after_discount', $this->unit_price_after_discount, true);
        $criteria->compare('quantity_return', $this->quantity_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
