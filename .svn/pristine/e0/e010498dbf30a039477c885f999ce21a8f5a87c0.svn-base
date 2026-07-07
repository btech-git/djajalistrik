<?php

class DeliveryNewProduct extends DeliveryNewProductBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
        
        public function getTotal()
	{
		return $this->quantity * $this->orderNewProduct->unit_price * $this->orderNewProduct->discountValue;
	}
        
        public function getQuantityOrdered()
	{
		$sql = "SELECT ordered.quantity - COALESCE(delivery.quantity_delivery, 0) AS quantity_ordered
				FROM
				(
					SELECT id, quantity AS quantity, unit_id, order_header_id
					FROM tbldl_order_new_product
					WHERE is_inactive = 0
				) ordered
				LEFT OUTER JOIN
				(
					SELECT order_new_product_id, SUM(quantity) AS quantity_delivery
					FROM tbldl_delivery_new_product 
					WHERE is_inactive = 0
					GROUP BY order_new_product_id
				) delivery
				ON ordered.id = delivery.order_new_product_id
				WHERE ordered.id = :order_new_product_id 
					AND (
						ordered.quantity - COALESCE(delivery.quantity_delivery, 0) > 0
						
					)";

		$value = CActiveRecord::$db->createCommand($sql)->queryRow(false, array(':order_new_product_id' => $this->order_new_product_id));
		
		return ($value[0] == 0) ? $value[1] : $value[0];
	}
    
    public function getTotalQuantityReturn() {
        $total = 0.00;
        
        foreach($this->saleReturnNewProducts as $detail) {
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
                SELECT delivery_new_product_id 
                FROM " . InvoiceNewProduct::model()->tableName() . " 
                WHERE is_inactive = 0
            )
        ";

		$criteria->compare('id', $this->id);
		$criteria->compare('quantity', $this->quantity);
		$criteria->compare('order_new_product_id', $this->order_new_product_id);
		$criteria->compare('delivery_header_id', $this->delivery_header_id);
		$criteria->compare('is_inactive', $this->is_inactive);
		$criteria->compare('product_name', $this->product_name, true);
		$criteria->compare('receive_new_product_id', $this->receive_new_product_id);
		$criteria->compare('quantity_return', $this->quantity_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}