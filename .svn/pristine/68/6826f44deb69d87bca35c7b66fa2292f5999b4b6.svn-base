<?php

class PurchaseDetail extends PurchaseDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getQuantityOrdered($orderHeaderId) {
        $sql = "SELECT ordered.quantity - COALESCE(purchase.quantity_receive, 0) AS quantity_ordered
                FROM
                (
                    SELECT h.id, d.quantity, d.product_id
                    FROM " . OrderHeader::model()->tableName() . " h
                    INNER JOIN " . OrderDetail::model()->tableName() . " d ON h.id = d.order_header_id
                    WHERE h.is_inactive = 0 AND d.is_inactive = 0
                ) ordered
                LEFT OUTER JOIN
                (
                    SELECT h.order_header_id, SUM(d.quantity) AS quantity_receive, d.product_id
                    FROM " . PurchaseHeader::model()->tableName() . " h
                    INNER JOIN " . PurchaseDetail::model()->tableName() . " d ON h.id = d.purchase_header_id
                    WHERE h.is_inactive = 0 AND d.is_inactive = 0
                    GROUP BY h.order_header_id, d.product_id
                ) purchase
                ON ordered.id = purchase.order_header_id AND ordered.product_id = purchase.product_id
                INNER JOIN " . Product::model()->tableName() . " p ON ordered.product_id = p.id
                WHERE ordered.id = :order_id AND ordered.product_id =:product_id AND NOT (purchase.product_id IS NOT NULL 
                AND purchase.order_header_id IS NULL) AND ordered.quantity - COALESCE(purchase.quantity_receive, 0)> 0
                GROUP BY ordered.id, ordered.product_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(':order_id' => $orderHeaderId, ':product_id' => $this->product_id));

        return ($value === false) ? 0 : $value;
    }

    public function getPriceAfterDiscount() {
        return ((((($this->unit_price * (1 + $this->discount_1 / 100)) * (1 + $this->discount_2 / 100)) * (1 + $this->discount_3 / 100)) * (1 + $this->discount_4 / 100)) * (1 + $this->discount_5 / 100));
    }

    public function getTotal() {
        return $this->quantity * $this->priceAfterDiscount;
    }

    public function getTotalQuantityReceive() {
        $total = 0;

        foreach ($this->receiveDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity_receive;
            }
        }

        return $total;
    }

    public function getTotalQuantityReturn() {
        $total = 0;

        foreach ($this->receiveDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->totalQuantityReturn;
            }
        }

        return $total;
    }
}