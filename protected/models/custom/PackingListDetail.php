<?php

class PackingListDetail extends PackingListDetailBase {

    public $quantity_current; 
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCurrentStock($warehouseId = false) {
        $sql = "
            SELECT COALESCE(SUM(quantity_in - quantity_out), 0) AS stock
            FROM " . Inventory::model()->tableName(). "
            WHERE product_id = :product_id AND warehouse_id = :warehouse_id AND is_inactive = 0
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->orderDetail->product_id,
            ':warehouse_id' => ($warehouseId !== false) ? $warehouseId : $this->packingListHeader->warehouse_id,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function searchForDelivery() {
        $criteria = new CDbCriteria;

        $criteria->condition = "
            t.id NOT IN (
                SELECT packing_list_detail_id 
                FROM " . DeliveryDetail::model()->tableName() . " 
                WHERE is_inactive = 0
            )
        ";

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