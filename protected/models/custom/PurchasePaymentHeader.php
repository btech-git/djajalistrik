<?php

class PurchasePaymentHeader extends PurchasePaymentHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalReceipt() {
        return $total = ($this->purchaseReceiptHeader === null) ? 0.00 : $this->purchaseReceiptHeader->totalDetail;
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->purchasePaymentDetails as $detail) {
            $total += $detail->amount;
        }

        return $total;
    }
    
    public static function getMonthlyUserPurchasePaymentReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS payment_quantity, SUM(d.amount) AS payment_total, 
                    COUNT(DISTINCT r.supplier_id) AS supplier_quantity
                FROM " . PurchasePaymentHeader::model()->tableName() . " i
                INNER JOIN " . PurchasePaymentDetail::model()->tableName() . " d ON i.id = d.purchase_payment_header_id
                INNER JOIN " . PurchaseReceiptHeader::model()->tableName() . " r ON r.id = i.purchase_receipt_header_id
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
