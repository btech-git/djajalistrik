<?php

/**
 * @property integer $id
 * @property integer $packing_list_header_id
 * @property integer $is_inactive
 * @property integer $quantity
 * @property integer $order_detail_id
 *
 * @property DeliveryDetail[] $deliveryDetails
 * @property PackingListHeader $packingListHeader
 * @property OrderDetail $orderDetail
 */
class PackingListDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_packing_list_detail';
    }

    public function rules() {
        return array(
            array('packing_list_header_id, order_detail_id', 'required'),
            array('packing_list_header_id, is_inactive, quantity, order_detail_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('id, packing_list_header_id, is_inactive, quantity, order_detail_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryDetails' => array(self::HAS_MANY, 'DeliveryDetail', 'packing_list_detail_id'),
            'packingListHeader' => array(self::BELONGS_TO, 'PackingListHeader', 'packing_list_header_id'),
            'orderDetail' => array(self::BELONGS_TO, 'OrderDetail', 'order_detail_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'packing_list_header_id' => 'Packing List Header',
            'is_inactive' => 'Is Inactive',
            'quantity' => 'Quantity',
            'order_detail_id' => 'Order Detail',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('packing_list_header_id', $this->packing_list_header_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('order_detail_id', $this->order_detail_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
