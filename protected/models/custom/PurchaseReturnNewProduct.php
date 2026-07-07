<?php

class PurchaseReturnNewProduct extends PurchaseReturnNewProductBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal($receiveHeaderId = null) {
        return $this->quantity * $this->receiveNewProduct->purchaseNewProduct->unit_price;
    }

    public function getQuantityReceived($receiveDetailId = null) {
        
        $sql = "SELECT quantity - quantity_return AS remaining
				FROM " . ReceiveNewProduct::model()->tableName() . "
				WHERE id = :receive_detail_id AND is_inactive = 0
				HAVING remaining > 0";

        $params = array(
            ':receive_detail_id' => ($receiveDetailId === null) ? $this->receive_new_product_id : $receiveDetailId,
        );

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0.00 : $value;
    }
}