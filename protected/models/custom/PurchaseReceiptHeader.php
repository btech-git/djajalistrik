<?php

class PurchaseReceiptHeader extends PurchaseReceiptHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByPurchasePayment() {
        $criteria = new CDbCriteria;

        $criteria->order = 't.id DESC';
        $criteria->condition = "EXISTS (
            SELECT h.grand_total - h.payment_total AS remaining 
            FROM " . PurchaseReceiptHeader::model()->tableName() . " h 
            WHERE t.id = h.id AND h.is_inactive = 0
            HAVING remaining > 0
        ) AND t.is_inactive = 0";

        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->purchaseReceiptDetails as $detail) {
            $total += $detail->amount;
        }

        return $total;
    }

    public function getTotalPayment() {
        $payment = 0.00;

        foreach ($this->purchasePaymentHeaders as $paymentHeader) {
            $payment += $paymentHeader->totalDetail;
        }

        return $payment;
    }

    public function getRemaining() {
        return $this->grand_total - $this->payment_total;
    }

    public function getRemainingDashboard() {
        $payable = $this->remaining;

        if ($payable > 0) {
            return $payable;
        }
    }
    
    public static function getMonthlyUserPurchaseReceiptReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS purchase_quantity, SUM(i.grand_total) AS purchase_total, 
                    COUNT(DISTINCT i.supplier_id) AS supplier_quantity
                FROM " . PurchaseReceiptHeader::model()->tableName() . " i
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
