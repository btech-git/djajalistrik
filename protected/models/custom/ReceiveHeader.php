<?php

class ReceiveHeader extends ReceiveHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByPurchaseReturn() {
        $criteria = new CDbCriteria;

        $criteria->condition = 'EXISTS (
            SELECT quantity_receive - quantity_return AS remaining
            FROM ' . ReceiveDetail::model()->tableName() . '
            WHERE t.id = receive_header_id AND is_inactive = 0
            HAVING remaining > 0
            UNION ALL
            SELECT quantity - quantity_return AS remaining
            FROM ' . ReceiveNewProduct::model()->tableName() . ' 
            WHERE t.id = receive_header_id AND is_inactive = 0
            HAVING remaining > 0
        ) AND t.is_inactive = 0';

        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.purchase_header_id', $this->purchase_header_id, true);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public function searchByPurchaseReceipt() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.id NOT IN (
            SELECT receive_header_id 
            FROM " . PurchaseReceiptDetail::model()->tableName() . " 
            WHERE is_inactive = 0
        ) AND t.is_inactive = 0";

        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.reference', $this->reference, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.purchase_header_id', $this->purchase_header_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }
    
    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->receiveDetails as $detail) {
            $total += $detail->total;
        }

        return $total;
    }

    public function getTotalNewProduct() {
        $total = 0.00;

        foreach ($this->receiveNewProducts as $newProduct) {
            $total += $newProduct->total;
        }

        return $total;
    }

    public function getSubTotal() {
        $subTotal = 0.00;

        if ((int) $this->purchaseHeader->is_tax == 0 && (int) $this->purchaseHeader->is_include == 0) {
            $subTotal = ($this->totalDetail + $this->totalNewProduct) / (1 + ($this->purchaseHeader->tax / 100));
        } else {
            $subTotal = $this->totalDetail + $this->totalNewProduct;
        }

        return $subTotal;
    }

    public function getTotalTax() {
        
        return ((int)$this->purchaseHeader->is_tax == 0) ? $this->subTotal * ($this->purchaseHeader->tax / 100) : 0.00;
    }

    public function getGrandTotal() {
        
        return $this->subTotal + $this->totalTax;
    }

    public function hasReference() {
        if (count($this->purchaseReturnHeaders) > 0) {
            return true;
        }

        return false;
    }

    public static function getMonthlyUserReceiveReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS receive_quantity
                FROM " . ReceiveHeader::model()->tableName() . " i
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}