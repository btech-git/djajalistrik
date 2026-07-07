<?php

class SalePaymentHeader extends SalePaymentHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalReceipt() {
        return ($this->saleReceiptHeader === null) ? 0.00 : $this->saleReceiptHeader->totalDetail;
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->salePaymentDetails as $detail) {
            $total += $detail->amount + $detail->additional_amount;
        }

        return $total;
    }

    public function getTotalInvoice() {
        $total = 0.00;

        foreach ($this->salePaymentDetails as $detail) {
            $total += $detail->total_invoice;
        }

        return $total;
    }

    public function getRemaining() {
        
        return $this->totalInvoice - $this->totalDetail;
    }
    
    public static function getMonthlyUserSalePaymentReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS payment_quantity, SUM(amount) AS payment_total, 
                    COUNT(DISTINCT i.customer_id) AS customer_quantity
                FROM " . SalePaymentHeader::model()->tableName() . " i
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                INNER JOIN " . SalePaymentDetail::model()->tableName() . " d ON i.id = d.sale_payment_header_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}