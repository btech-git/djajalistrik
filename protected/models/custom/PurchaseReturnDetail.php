<?php

class PurchaseReturnDetail extends PurchaseReturnDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal() {
        return $this->quantity * $this->receiveDetail->purchaseDetail->unit_price;
    }

    public function getQuantityReceived($receiveDetailId = null) {
        
        $sql = "SELECT quantity_receive - quantity_return AS remaining
                FROM " . ReceiveDetail::model()->tableName() . "
                WHERE id = :receive_detail_id AND is_inactive = 0
                HAVING remaining > 0";

        $params = array(
            ':receive_detail_id' => ($receiveDetailId === null) ? $this->receive_detail_id : $receiveDetailId,
        );

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0.00 : $value;
    }

}