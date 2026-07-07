<?php

class SaleReturnDetail extends SaleReturnDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
//	public function getUnitPrice($orderId = null)
//	{
//		$orderDetail = OrderDetail::model()->findByAttributes(array(
//			'order_header_id' => ($orderId === null) ? $this->saleReturnHeader->order_header_id : $orderId,
//			'product_id' => $this->orderDetail->product_id,
//		));
//
//		return ($orderDetail === null) ? 0.00 : $orderDetail->unit_price;
//	}

	public function getTotal()
	{
		return $this->quantity * $this->unit_price;
	}
	
//	public function getQuantityOrdered($orderId = null)
//	{
//		if ($this->isNewRecord)
//			$returnSql = '';
//		else
//			$returnSql = 'AND h.id <> :return_id';
//		
//		$sql = "SELECT ordered.quantity - COALESCE(returned.quantity_returned, 0)AS quantity_ordered
//				FROM
//				(
//					SELECT h.id, d.quantity, d.product_id
//					FROM tbldl_order_header h
//					INNER JOIN tbldl_order_detail d ON h.id = d.order_header_id
//					WHERE h.is_inactive = 0 AND d.is_inactive = 0
//				) ordered
//				LEFT OUTER JOIN
//				(
//					SELECT h.order_header_id, SUM(COALESCE(d.quantity, 0)) AS quantity_returned, d.product_id
//					FROM tbldl_sale_return_header h
//					INNER JOIN tbldl_sale_return_detail d ON h.id = d.sale_return_header_id
//					WHERE h.is_inactive = 0 AND d.is_inactive = 0 {$returnSql}
//					GROUP BY h.order_header_id, d.product_id
//				) returned
//				ON ordered.id = returned.order_header_id AND ordered.product_id = returned.product_id
//				INNER JOIN tbldl_product
//				ON ordered.product_id = tbldl_product.id
//				WHERE ordered.id = :order_id AND ordered.product_id = :product_id AND NOT (returned.product_id IS NOT NULL 
//				AND returned.order_header_id IS NULL) AND ordered.quantity - COALESCE(returned.quantity_returned, 0) > 0
//				GROUP BY ordered.id, ordered.product_id";
//
//		$params = array(
//			'order_id' => ($orderId === null) ? $this->saleReturnHeader->order_header_id : $orderId,
//			'product_id' => $this->product_id,
//		);
//
//		if (!$this->isNewRecord)
//			$params['return_id'] = $this->saleReturnHeader->id;
//
//		$value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);
//
//		return ($value === false) ? 0.00 : $value;
//	}
	
//	public function getQuantityOrdered()
//	{
//		$sql = "SELECT ordered.quantity - COALESCE(returned.quantity, 0) AS quantity_ordered
//				FROM
//				(
//					SELECT id, quantity, unit_id, order_header_id
//					FROM tbldl_order_detail 
//					WHERE is_inactive = 0
//				) ordered
//				LEFT OUTER JOIN
//				(
//					SELECT order_detail_id, SUM(quantity) AS quantity
//					FROM tbldl_sale_return_detail 
//					WHERE is_inactive = 0
//					GROUP BY order_detail_id
//				) returned
//				ON ordered.id = returned.order_detail_id
//				WHERE ordered.id = :order_detail_id AND ordered.quantity - COALESCE(returned.quantity, 0) > 0";
//
//		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(':order_detail_id' => $this->order_detail_id));
//		
//		return ($value === false) ? 0 : $value;
//	}
}