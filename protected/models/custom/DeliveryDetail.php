<?php

class DeliveryDetail extends DeliveryDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getQuantityOrdered() {
        //original. before added quantity_single
//		$sql = "SELECT ordered.quantity - COALESCE(delivery.quantity_delivery, 0) AS quantity_ordered
//				FROM
//				(
//					SELECT id, quantity_bulk AS quantity, unit_id, order_header_id
//					FROM tbldl_order_detail 
//					WHERE is_inactive = 0
//				) ordered
//				LEFT OUTER JOIN
//				(
//					SELECT order_detail_id, SUM(quantity) AS quantity_delivery
//					FROM tbldl_delivery_detail 
//					WHERE is_inactive = 0
//					GROUP BY order_detail_id
//				) delivery
//				ON ordered.id = delivery.order_detail_id
//				WHERE ordered.id = :order_detail_id AND ordered.quantity - COALESCE(delivery.quantity_delivery, 0) > 0";

        $sql = "SELECT ordered.quantity_bulk - COALESCE(delivery.quantity_delivery, 0) AS quantity_bulk_ordered,
					ordered.quantity_single - COALESCE(delivery.quantity_delivery, 0) AS quantity_single_ordered
				FROM
				(
					SELECT id, quantity_bulk AS quantity_bulk, quantity_single AS quantity_single, unit_id, order_header_id
					FROM tbldl_order_detail 
					WHERE is_inactive = 0
				) ordered
				LEFT OUTER JOIN
				(
					SELECT order_detail_id, SUM(quantity) AS quantity_delivery
					FROM tbldl_delivery_detail 
					WHERE is_inactive = 0
					GROUP BY order_detail_id
				) delivery
				ON ordered.id = delivery.order_detail_id
				WHERE ordered.id = :order_detail_id AND (
                    ordered.quantity_bulk - COALESCE(delivery.quantity_delivery, 0) > 0
                    OR ordered.quantity_single - COALESCE(delivery.quantity_delivery, 0) > 0
                )";

        //original
//		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(':order_detail_id' => $this->order_detail_id));
        $value = CActiveRecord::$db->createCommand($sql)->queryRow(false, array(':order_detail_id' => $this->order_detail_id));

        return ($value[0] == 0) ? $value[1] : $value[0];
    }

    public function getTotal() {
        return $this->quantity * $this->orderDetail->unit_price_single * $this->orderDetail->discountValue;
    }

    public function getCurrentStock($warehouseId = false) {
        $sql = "
            SELECT COALESCE(SUM(quantity_in - quantity_out), 0) AS stock
            FROM " . Inventory::model()->tableName(). "
            WHERE product_id = :product_id AND warehouse_id = :warehouse_id AND is_inactive = 0
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->orderDetail->product_id,
            ':warehouse_id' => ($warehouseId !== false) ? $warehouseId : $this->deliveryHeader->warehouse_id,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getTotalQuantityReturn() {
        $total = 0.00;
        
        foreach($this->saleReturnDetails as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }
    
    public function getQuantityReturnRemaining() {
        return $this->quantity - $this->quantity_return;
    }

    public function searchForInvoice() {
        $criteria = new CDbCriteria;

        $criteria->condition = "
            t.id NOT IN (
                SELECT delivery_detail_id 
                FROM " . InvoiceDetail::model()->tableName() . " 
                WHERE is_inactive = 0
            )
        ";

		$criteria->compare('id', $this->id);
		$criteria->compare('quantity', $this->quantity);
		$criteria->compare('order_detail_id', $this->order_detail_id);
		$criteria->compare('delivery_header_id', $this->delivery_header_id);
		$criteria->compare('unit_id', $this->unit_id);
		$criteria->compare('is_inactive', $this->is_inactive);
		$criteria->compare('product_name', $this->product_name, true);
		$criteria->compare('packing_list_detail_id', $this->packing_list_detail_id);
		$criteria->compare('quantity_return', $this->quantity_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}