<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property integer $purchase_return_header_id
 * @property integer $receive_new_product_id
 * @property integer $is_inactive
 *
 * @property PurchaseReturnHeader $purchaseReturnHeader
 * @property ReceiveNewProduct $receiveNewProduct
 */
class PurchaseReturnNewProductBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_purchase_return_new_product';
    }

    public function rules() {
        return array(
            array('quantity, purchase_return_header_id, receive_new_product_id', 'required'),
            array('quantity, purchase_return_header_id, receive_new_product_id, is_inactive', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('id, quantity, purchase_return_header_id, receive_new_product_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseReturnHeader' => array(self::BELONGS_TO, 'PurchaseReturnHeader', 'purchase_return_header_id'),
            'receiveNewProduct' => array(self::BELONGS_TO, 'ReceiveNewProduct', 'receive_new_product_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'purchase_return_header_id' => 'Purchase Return Header',
            'receive_new_product_id' => 'Receive New Product',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('purchase_return_header_id', $this->purchase_return_header_id);
        $criteria->compare('receive_new_product_id', $this->receive_new_product_id);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
