<?php

class ReceiveNewProduct extends ReceiveNewProductBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getQuantityOrdered($purchaseHeaderId) {
        $sql = "SELECT purchase.quantity - COALESCE(receive.quantity_receive, 0) AS quantity_ordered
                FROM (
                    SELECT h.id, d.quantity, d.id AS new_product_id
                    FROM " . PurchaseHeader::model()->tableName() . " h
                    INNER JOIN " . PurchaseNewProduct::model()->tableName() . " d ON h.id = d.purchase_header_id
                    WHERE h.is_inactive = 0 AND d.is_inactive = 0
                ) purchase
                LEFT OUTER JOIN (
                    SELECT h.purchase_header_id, SUM(d.quantity) AS quantity_receive, d.purchase_new_product_id
                    FROM " . ReceiveHeader::model()->tableName() . " h
                    INNER JOIN " . ReceiveNewProduct::model()->tableName() . " d ON h.id = d.receive_header_id
                    WHERE h.is_inactive = 0 AND d.is_inactive = 0
                    GROUP BY h.purchase_header_id, d.purchase_new_product_id
                ) receive
                ON purchase.id = receive.purchase_header_id
                AND purchase.new_product_id = receive.purchase_new_product_id
                WHERE purchase.id = :purchase_id AND purchase.new_product_id = :new_product_id
                AND purchase.quantity - COALESCE(receive.quantity_receive, 0) > 0";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(':purchase_id' => $purchaseHeaderId, ':new_product_id' => $this->purchase_new_product_id));

        return ($value === false) ? 0 : $value;
    }

    public function getTotal() {
        return ($this->quantity - $this->quantity_return) * $this->purchaseNewProduct->priceAfterDiscount;
    }

    public function getTotalQuantityReturn() {
        $total = 0;

        foreach ($this->purchaseReturnNewProducts as $detail) {
            $total += $detail->quantity;
        }

        return $total;
    }

    public function getQuantityRemaining() {
        return $this->quantity - $this->quantity_return;
    }
}
