<?php

class SqlGenerator extends CComponent
{
	public static function localStock()
	{
		$sql = "SELECT receive.quantity - purchase_return.quantity + adjustment.quantity - transfer_from.quantity + transfer_to.quantity - delivery.quantity + sale_return.quantity AS current_stock FROM
				(
					".SqlViewGenerator::receiveStock()."
					WHERE d.product_id = :product_id AND h.warehouse_id = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0
				) receive
				CROSS JOIN
				(
					".SqlViewGenerator::purchaseReturnStock()."
					INNER JOIN ".ReceiveHeader::model()->tableName()." r ON r.id = h.receive_header_id
					WHERE d.product_id = :product_id AND h.warehouse_id = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0 AND r.is_inactive = 0
				) purchase_return
				CROSS JOIN
				(
					".SqlViewGenerator::adjustmentStock()."
					WHERE d.product_id = :product_id AND h.warehouse_id = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0
				) adjustment
				CROSS JOIN
				(
					".SqlViewGenerator::transferStock()."
					WHERE d.product_id = :product_id AND h.warehouse_id_from = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0
				) transfer_from
				CROSS JOIN
				(
					".SqlViewGenerator::transferStock()."
					WHERE d.product_id = :product_id AND h.warehouse_id_to = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0
				) transfer_to
				CROSS JOIN
				(
					".SqlViewGenerator::deliveryStock()."
					WHERE o.product_id = :product_id AND h.warehouse_id = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0
				) delivery
				CROSS JOIN
				(
					".SqlViewGenerator::saleReturnStock()."
					WHERE o.product_id = :product_id AND h.warehouse_id = :warehouse_id AND h.is_inactive = 0 AND d.is_inactive = 0
				) sale_return";

		return $sql;
	}
	
	public static function globalStock()
	{
		$sql = "SELECT receive.quantity - purchase_return.quantity + adjustment.quantity - transfer_from.quantity + transfer_to.quantity - delivery.quantity + sale_return.quantity AS current_stock FROM
				(
					".SqlViewGenerator::receiveStock()."
					WHERE d.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) receive
				CROSS JOIN
				(
					".SqlViewGenerator::purchaseReturnStock()."
					WHERE d.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) purchase_return
				CROSS JOIN
				(
					".SqlViewGenerator::adjustmentStock()."
					WHERE d.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) adjustment
				CROSS JOIN
				(
					".SqlViewGenerator::transferStock()."
					WHERE d.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) transfer_from
				CROSS JOIN
				(
					".SqlViewGenerator::transferStock()."
					WHERE d.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) transfer_to
				CROSS JOIN
				(
					".SqlViewGenerator::deliveryStock()."
					WHERE o.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) delivery
				CROSS JOIN
				(
					".SqlViewGenerator::saleReturnStock()."
					WHERE o.product_id = :product_id AND d.unit_id = :unit_id_single AND h.is_inactive = 0 AND d.is_inactive = 0
				) sale_return";

		return $sql;
	}

	public static function stockBeginning()
	{
		$sql = "SELECT SUM(quantity_in) - SUM(quantity_out) 
				FROM tbldl_inventory 
				WHERE product_id = :product_id AND date < :start_date";

		return $sql;
	}

	public static function stockEnding()
	{
		$sql = "SELECT SUM(quantity_in) - SUM(quantity_out) 
				FROM tbldl_inventory 
				WHERE product_id = :product_id AND date <= :end_date";

		return $sql;
	}

	public static function stockIn()
	{
		$sql = "SELECT SUM(quantity_in) 
				FROM tbldl_inventory 
				WHERE product_id = :product_id AND date BETWEEN :start_date AND :end_date";

		return $sql;
	}

	public static function stockOut()
	{
		$sql = "SELECT SUM(quantity_out) 
				FROM tbldl_inventory 
				WHERE product_id = :product_id AND date BETWEEN :start_date AND :end_date";

		return $sql;
	}

	public static function bankBook()
	{
		$sql = "SELECT dc.date, a.name AS account, dc.debit, dc.credit FROM
				(
					SELECT h.date, h.account_id, d.account_id AS detail_account_id, d.amount AS debit, 0 AS credit FROM tbldl_deposit_header h INNER JOIN tbldl_deposit_detail d ON h.id = d.deposit_header_id
					UNION
					SELECT h.date, h.account_id, d.account_id AS detail_account_id, 0 AS debit, d.amount AS credit FROM tbldl_expense_header h INNER JOIN tbldl_expense_detail d ON h.id = d.expense_header_id
				) dc
				INNER JOIN tbldl_account a ON a.id = dc.detail_account_id
				WHERE dc.account_id = :account_id AND dc.date BETWEEN :start_date AND :end_date
				ORDER BY date ASC, account ASC";

		return $sql;
	}
	
}
