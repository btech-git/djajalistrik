<?php

class SqlViewGenerator extends CComponent {

    public static function count($view) {
        $sql = "SELECT COUNT(*) FROM ({$view}) v";

        return $sql;
    }

    public static function receiveStock() {
        $sql = "SELECT COALESCE(SUM(d.quantity_receive), 0) AS quantity 
				FROM " . ReceiveHeader::model()->tableName() . " h 
				INNER JOIN " . ReceiveDetail::model()->tableName() . " d ON h.id = d.receive_header_id";

        return $sql;
    }

    public static function purchaseReturnStock() {
        $sql = "SELECT COALESCE(SUM(d.quantity), 0) AS quantity 
				FROM " . PurchaseReturnHeader::model()->tableName() . " h 
				INNER JOIN " . PurchaseReturnDetail::model()->tableName() . " d ON h.id = d.purchase_return_header_id";

        return $sql;
    }

    public static function adjustmentStock() {
        $sql = "SELECT COALESCE(SUM(d.quantity_adjustment - d.quantity_current), 0) AS quantity 
				FROM " . AdjustmentHeader::model()->tableName() . " h 
				INNER JOIN " . AdjustmentDetail::model()->tableName() . " d ON h.id = d.adjustment_header_id";

        return $sql;
    }

    public static function transferStock() {
        $sql = "SELECT COALESCE(SUM(d.quantity), 0) AS quantity 
				FROM " . TransferHeader::model()->tableName() . " h 
				INNER JOIN " . TransferDetail::model()->tableName() . " d ON h.id = d.transfer_header_id";

        return $sql;
    }

    public static function deliveryStock() {
        $sql = "SELECT COALESCE(SUM(d.quantity), 0) AS quantity 
				FROM " . DeliveryHeader::model()->tableName() . " h 
				INNER JOIN " . DeliveryDetail::model()->tableName() . " d ON h.id = d.delivery_header_id
				INNER JOIN " . OrderDetail::model()->tableName() . " o ON o.id = d.order_detail_id";

        return $sql;
    }

    public static function saleReturnStock() {
        $sql = "SELECT COALESCE(SUM(d.quantity), 0) AS quantity 
				FROM " . SaleReturnHeader::model()->tableName() . " h 
				INNER JOIN " . SaleReturnDetail::model()->tableName() . " d ON h.id = d.sale_return_header_id
				INNER JOIN " . OrderDetail::model()->tableName() . " o ON o.id = d.order_detail_id";

        return $sql;
    }

    public static function globalStock() {
        $sql = "SELECT p.id, p.unit_id_single, COALESCE(receive.quantity, 0) - COALESCE(purchase_return.quantity, 0) + COALESCE(adjustment.quantity, 0) - COALESCE(transfer_from.quantity, 0) + COALESCE(transfer_to.quantity, 0) - COALESCE(delivery.quantity, 0) + COALESCE(sale_return.quantity, 0) AS current_stock
				FROM " . Product::model()->tableName() . " p
				LEFT OUTER JOIN
				(
					SELECT d.product_id, d.unit_id, COALESCE(SUM(d.quantity_receive), 0) AS quantity 
					FROM " . ReceiveHeader::model()->tableName() . " h 
					INNER JOIN " . ReceiveDetail::model()->tableName() . " d ON h.id = d.receive_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY d.product_id, d.unit_id
				) receive
				ON p.id = receive.product_id AND p.unit_id_single = receive.unit_id
				LEFT OUTER JOIN
				(
					SELECT d.product_id, d.unit_id, COALESCE(SUM(d.quantity), 0) AS quantity 
					FROM " . PurchaseReturnHeader::model()->tableName() . " h 
					INNER JOIN " . PurchaseReturnDetail::model()->tableName() . " d ON h.id = d.purchase_return_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY d.product_id, d.unit_id
				) purchase_return
				ON p.id = purchase_return.product_id AND p.unit_id_single = purchase_return.unit_id
				LEFT OUTER JOIN
				(
					SELECT d.product_id, d.unit_id, COALESCE(SUM(d.quantity_adjustment - d.quantity_current), 0) AS quantity 
					FROM " . AdjustmentHeader::model()->tableName() . " h 
					INNER JOIN " . AdjustmentDetail::model()->tableName() . " d ON h.id = d.adjustment_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY d.product_id, d.unit_id
				) adjustment
				ON p.id = adjustment.product_id AND p.unit_id_single = adjustment.unit_id
				LEFT OUTER JOIN
				(
					SELECT d.product_id, d.unit_id, COALESCE(SUM(d.quantity), 0) AS quantity 
					FROM " . TransferHeader::model()->tableName() . " h 
					INNER JOIN " . TransferDetail::model()->tableName() . " d ON h.id = d.transfer_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY d.product_id, d.unit_id
				) transfer_from
				ON p.id = transfer_from.product_id AND p.unit_id_single = transfer_from.unit_id
				LEFT OUTER JOIN
				(
					SELECT d.product_id, d.unit_id, COALESCE(SUM(d.quantity), 0) AS quantity 
					FROM " . TransferHeader::model()->tableName() . " h 
					INNER JOIN " . TransferDetail::model()->tableName() . " d ON h.id = d.transfer_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY d.product_id, d.unit_id
				) transfer_to
				ON p.id = transfer_to.product_id AND p.unit_id_single = transfer_to.unit_id
				LEFT OUTER JOIN
				(
					SELECT h.product_id, h.unit_id, COALESCE(SUM(d.quantity), 0) AS quantity 
					FROM " . OrderDetail::model()->tableName() . " h 
					LEFT OUTER JOIN " . DeliveryDetail::model()->tableName() . " d ON h.id = d.order_detail_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.product_id, h.unit_id
				) delivery
				ON p.id = delivery.product_id AND p.unit_id_single = delivery.unit_id
				LEFT OUTER JOIN
				(
					SELECT h.product_id, h.unit_id, COALESCE(SUM(d.quantity), 0) AS quantity 
					FROM " . OrderDetail::model()->tableName() . " h 
					LEFT OUTER JOIN " . SaleReturnDetail::model()->tableName() . " d ON h.id = d.order_detail_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.product_id, h.unit_id
				) sale_return
				ON p.id = sale_return.product_id AND p.unit_id_single = sale_return.unit_id";

        return $sql;
    }

    public static function excelCategorySize() {
        $sql = "SELECT DISTINCT category_id, size 
				FROM " . Product::model()->tableName() . "  
				WHERE is_inactive = 0 ORDER BY category_id, size";

        return $sql;
    }

    public static function excelGlobalStock() {
        $sql = "SELECT p.category_id, p.name, c.name AS category_name, ps.current_stock
				FROM " . Product::model()->tableName() . " p 
				INNER JOIN " . Category::model()->tableName() . " c ON p.category_id = c.id
				INNER JOIN (" . SqlViewGenerator::globalStock() . ") ps
				ON p.id = ps.id
				WHERE p.is_inactive = 0 AND c.is_inactive = 0
				ORDER BY p.category_id, p.name";

        return $sql;
    }

    public static function salePaymentRemaining() {
        $sql = "SELECT receipt.total_sale - COALESCE(payment.amount, 0) AS remaining FROM
				(
					SELECT receipt_detail.sale_receipt_header_id AS id, SUM(sale.total) AS total_sale 
					FROM " . SaleReceiptDetail::model()->tableName() . " AS receipt_detail INNER JOIN 
					(
						SELECT ordered.id, invoice.id AS invoice_id, (SUM(ordered.quantity * ordered.discount_price) + ordered.shipping - ordered.deposit) - (SUM(COALESCE(returned.quantity_returned, 0) * ordered.unit_price)) AS total 
						FROM
						(
							SELECT h.id, d.product_id, d.quantity, d.unit_price, (((((d.unit_price * (1 + (d.discount_1 / 100))) * (1 + (d.discount_2 / 100))) * (1 + (d.discount_3 / 100))) * (1 + (d.discount_4 / 100))) * (1 + (d.discount_5 / 100))) AS discount_price, h.shipping_fee AS shipping, h.deposit
							FROM " . OrderHeader::model()->tableName() . " h 
							INNER JOIN " . OrderDetail::model()->tableName() . " d ON h.id = d.order_header_id
							WHERE h.is_inactive = 0 AND d.is_inactive = 0
						) ordered
						LEFT OUTER JOIN
						(
							SELECT id, order_header_id
							FROM " . Invoice::model()->tableName() . "
							WHERE is_inactive = 0
						) invoice
						ON ordered.id = invoice.order_header_id
						LEFT OUTER JOIN
						(
							SELECT h.order_header_id, d.product_id, SUM(d.quantity) AS quantity_returned 
							FROM " . SaleReturnHeader::model()->tableName() . " h
							INNER JOIN " . SaleReturnDetail::model()->tableName() . " d ON h.id = d.sale_return_header_id
							WHERE h.is_inactive = 0 AND d.is_inactive = 0
							GROUP BY h.order_header_id, d.product_id
						) returned
						ON ordered.id = returned.order_header_id AND ordered.product_id = returned.product_id
                        GROUP BY ordered.id, invoice_id
					) sale
					ON receipt_detail.invoice_id = sale.invoice_id
					WHERE receipt_detail.is_inactive = 0
					GROUP BY id
				) receipt
				LEFT OUTER JOIN
				(
					SELECT h.sale_receipt_header_id, COALESCE(SUM(d.amount), 0) AS amount 
					FROM " . SalePaymentHeader::model()->tableName() . " h 
					INNER JOIN " . SalePaymentDetail::model()->tableName() . " d ON h.id = d.sale_payment_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.sale_receipt_header_id
				) payment
				ON receipt.id = payment.sale_receipt_header_id";

        return $sql;
    }

    public static function purchasePaymentRemaining() {
        $sql = "SELECT receipt.total_purchase - COALESCE(payment.amount, 0) AS remaining FROM
				(
					SELECT receipt_detail.purchase_receipt_header_id AS id, SUM(purchasing.total) AS total_purchase 
					FROM " . PurchaseReceiptDetail::model()->tableName() . " AS receipt_detail INNER JOIN 
					(
						SELECT purchased.id, SUM(((((((purchased.quantity - COALESCE(returned.quantity_returned, 0)) * purchased.unit_price * (1 + purchased.discount_1 / 100)) * (1 + purchased.discount_2 / 100)) * (1 + purchased.discount_3 / 100)) * (1 + purchased.discount_4 / 100)) * (1 + purchased.discount_5 / 100))) AS total FROM
						(
							SELECT h.id, d.product_id, d.quantity, d.unit_price, d.discount_1, d.discount_2, d.discount_3, d.discount_4, d.discount_5
							FROM " . PurchaseHeader::model()->tableName() . " h 
							INNER JOIN " . PurchaseDetail::model()->tableName() . " d ON h.id = d.purchase_header_id
							WHERE h.is_inactive = 0 AND d.is_inactive = 0
						) purchased
						LEFT OUTER JOIN
						(
							SELECT r.purchase_header_id, d.product_id, SUM(COALESCE(d.quantity, 0)) AS quantity_returned 
							FROM " . ReceiveHeader::model()->tableName() . " r
							INNER JOIN " . PurchaseReturnHeader::model()->tableName() . " h ON r.id = h.receive_header_id
							INNER JOIN " . PurchaseReturnDetail::model()->tableName() . " d ON h.id = d.purchase_return_header_id
							WHERE h.is_inactive = 0 AND d.is_inactive = 0
							GROUP BY r.purchase_header_id, d.product_id
						) returned
						ON purchased.id = returned.purchase_header_id AND purchased.product_id = returned.product_id
						GROUP BY purchased.id
					) purchasing
					ON receipt_detail.purchase_header_id = purchasing.id
					GROUP BY id
				) receipt
				LEFT OUTER JOIN
				(
					SELECT h.purchase_receipt_header_id, COALESCE(SUM(d.amount), 0) AS amount 
					FROM " . PurchasePaymentHeader::model()->tableName() . " h 
					INNER JOIN " . PurchasePaymentDetail::model()->tableName() . " d ON h.id = d.purchase_payment_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.purchase_receipt_header_id
				) payment
				ON receipt.id = payment.purchase_receipt_header_id";

        return $sql;
    }

    public static function orderStatus() {
        $sql = "SELECT ordered.product_id, ordered.unit_id, ordered.unit_price, ordered.quantity - COALESCE(purchase.quantity, 0) AS quantity_ordered FROM
				(
					SELECT h.id, d.product_id, d.unit_id, d.quantity_bulk AS quantity, d.unit_price_bulk AS unit_price
					FROM " . OrderHeader::model()->tableName() . "  h
					INNER JOIN " . OrderDetail::model()->tableName() . "  d ON h.id = d.order_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
				) ordered
				LEFT OUTER JOIN
				(
					SELECT h.order_header_id, d.product_id, d.unit_id, SUM(COALESCE(d.quantity, 0)) AS quantity
					FROM " . PurchaseHeader::model()->tableName() . "  h
					INNER JOIN " . PurchaseDetail::model()->tableName() . "  d ON h.id = d.purchase_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.order_header_id, d.product_id
				) purchase
				ON ordered.id = purchase.order_header_id
				AND ordered.product_id = purchase.product_id
				AND ordered.unit_id = purchase.unit_id";

        return $sql;
    }

    public static function quantityPurchase() {
        $sql = "SELECT purchase.product_id, purchase.unit_id, purchase.quantity - COALESCE(receive.quantity, 0) AS quantity_ordered
                FROM (
                    SELECT ph.id, pd.quantity, pd.product_id, pd.unit_id
                    FROM " . PurchaseHeader::model()->tableName() . " ph
                    INNER JOIN " . PurchaseDetail::model()->tableName() . " pd ON ph.id = pd.purchase_header_id
                    WHERE ph.is_inactive = 0 AND pd.is_inactive = 0
                ) purchase
                LEFT OUTER JOIN (
                    SELECT rh.purchase_header_id, SUM(rd.quantity_receive) AS quantity, rd.product_id
                    FROM " . ReceiveHeader::model()->tableName() . " rh
                    INNER JOIN " . ReceiveDetail::model()->tableName() . " rd ON rh.id = rd.receive_header_id
                    WHERE rh.is_inactive = 0 AND rd.is_inactive = 0
                    GROUP BY rh.purchase_header_id, rd.product_id
                ) receive
                ON purchase.id = receive.purchase_header_id
                AND purchase.product_id = receive.product_id";

        return $sql;
    }

    public static function quantityPurchaseNewProduct() {
        $sql = "SELECT purchase.purchase_new_product_id, purchase.product_name, purchase.quantity - COALESCE(receive.quantity, 0) AS quantity_ordered
				FROM
				(
					SELECT ph.id, pd.quantity, pd.product_name, pd.product_code, pd.id AS purchase_new_product_id
					FROM " . PurchaseHeader::model()->tableName() . " ph
					INNER JOIN " . PurchaseNewProduct::model()->tableName() . " pd ON ph.id = pd.purchase_header_id
					WHERE ph.is_inactive = 0 AND pd.is_inactive = 0
				) purchase
				LEFT OUTER JOIN
				(
					SELECT rh.purchase_header_id, SUM(rd.quantity) AS quantity, rd.purchase_new_product_id
					FROM " . ReceiveHeader::model()->tableName() . " rh
					INNER JOIN " . ReceiveNewProduct::model()->tableName() . " rd ON rh.id = rd.receive_header_id
					WHERE rh.is_inactive = 0 AND rd.is_inactive = 0
					GROUP BY rh.purchase_header_id, rd.purchase_new_product_id
				) receive
				ON purchase.id = receive.purchase_header_id
				AND purchase.purchase_new_product_id = receive.purchase_new_product_id";

        return $sql;
    }

    public static function quantityReceive() {
        $sql = "SELECT receive.unit_id, receive.quantity - COALESCE(returned.quantity, 0) AS quantity_received, receive.product_id
				FROM 
				(
					SELECT h.id, d.quantity_receive AS quantity, d.product_id, d.unit_id
					FROM " . ReceiveHeader::model()->tableName() . " h 
					INNER JOIN " . ReceiveDetail::model()->tableName() . " d ON h.id = d.receive_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
				) receive
				LEFT OUTER JOIN
				(
					SELECT h.receive_header_id, SUM(COALESCE(d.quantity, 0)) AS quantity, d.product_id
					FROM " . PurchaseReturnHeader::model()->tableName() . " h
					INNER JOIN " . PurchaseReturnDetail::model()->tableName() . " d ON h.id = d.purchase_return_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.receive_header_id, d.product_id
				) returned
				ON receive.id = returned.receive_header_id
				AND receive.product_id = returned.product_id";

        return $sql;
    }

    public static function quantityOrder() {
        $sql = "SELECT ordered.unit_id, ordered.quantity - COALESCE(returned.quantity, 0) AS quantity_ordered, ordered.product_id
				FROM 
				(
					SELECT h.id, d.quantity, d.product_id, d.unit_id
					FROM " . OrderHeader::model()->tableName() . " h 
					INNER JOIN " . OrderDetail::model()->tableName() . " d ON h.id = d.order_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
				) ordered
				LEFT OUTER JOIN
				(
					SELECT h.order_header_id, SUM(COALESCE(d.quantity, 0)) AS quantity, d.order_detail_id
					FROM " . SaleReturnHeader::model()->tableName() . " h
					INNER JOIN " . SaleReturnDetail::model()->tableName() . " d ON h.id = d.sale_return_header_id
					WHERE h.is_inactive = 0 AND d.is_inactive = 0
					GROUP BY h.order_header_id, d.order_detail_id
				) returned
				ON ordered.id = returned.order_header_id
				AND ordered.product_id = returned.order_detail_id";

        return $sql;
    }

}
