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
 * @property string $unit_price_after_discount
 * @property integer $invoice_header_id
 * @property integer $delivery_new_product_id
 * @property integer $is_inactive
 *
 * @property InvoiceHeader $invoiceHeader
 * @property DeliveryNewProduct $deliveryNewProduct
 */
class InvoiceNewProductBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_invoice_new_product';
    }

    public function rules() {
        return array(
            array('invoice_header_id, delivery_new_product_id', 'required'),
            array('quantity, invoice_header_id, delivery_new_product_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('unit_price, unit_price_after_discount', 'length', 'max' => 18),
            array('discount_1, discount_2, discount_3, discount_4, discount_5', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, quantity, unit_price, discount_1, discount_2, discount_3, discount_4, discount_5, unit_price_after_discount, invoice_header_id, delivery_new_product_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'invoiceHeader' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_header_id'),
            'deliveryNewProduct' => array(self::BELONGS_TO, 'DeliveryNewProduct', 'delivery_new_product_id'),
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
            'unit_price_after_discount' => 'Unit Price After Discount',
            'invoice_header_id' => 'Invoice Header',
            'delivery_new_product_id' => 'Delivery New Product',
            'is_inactive' => 'Is Inactive',
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
        $criteria->compare('unit_price_after_discount', $this->unit_price_after_discount, true);
        $criteria->compare('invoice_header_id', $this->invoice_header_id);
        $criteria->compare('delivery_new_product_id', $this->delivery_new_product_id);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}