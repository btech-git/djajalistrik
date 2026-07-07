<?php

class SaleReceiptHeader extends SaleReceiptHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchBySalePayment() {
        $criteria = new CDbCriteria;

        $criteria->order = 't.id DESC';
        $criteria->condition = 'EXISTS (
            SELECT h.grand_total - h.payment_total AS remaining 
            FROM tbldl_sale_receipt_header h 
            WHERE t.id = h.id
            HAVING remaining > 0
        )';

        $criteria->compare('number', $this->number, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('customer_id', $this->customer_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->saleReceiptDetails as $detail) {
            $total += $detail->invoice->totalDetail;
        }

        return $total;
    }

    public function getRemaining() {
        return $this->grand_total - $this->payment_total;
    }
    
    public static function getMonthlyUserSaleReceiptReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS invoice_quantity, SUM(i.total_invoice) AS invoice_total, 
                    COUNT(DISTINCT i.customer_id) AS customer_quantity
                FROM " . SaleReceiptHeader::model()->tableName() . " i
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
