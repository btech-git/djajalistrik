<?php

class PurchaseHeader extends PurchaseHeaderBase {

    const TAX = 0;
    const NON_TAX = 1;
    const TAX_LITERAL = 'Tax';
    const NON_TAX_LITERAL = 'Non Tax';
    const INCLUDE_TAX = 0;
    const NON_INCLUDE = 1;
    const INCLUDE_TAX_LITERAL = 'Include Tax';
    const NON_INCLUDE_LITERAL = 'Exclude Tax';
    const NOT_APPROVED = 0;
    const APPROVED = 1;
    const NOT_APPROVED_LITERAL = 'Not Approved';
    const APPROVED_LITERAL = 'Approved';
    const CLEARED = 1;
    const HOLD = 2;
    const CANCELED = 3;
    const CLEARED_LITERAL = 'Cleared';
    const HOLD_LITERAL = 'On Hold';
    const CANCELED_LITERAL = 'Canceled';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function approvalStatus() {
        return ($this->is_approved) ? self::APPROVED_LITERAL : self::NOT_APPROVED_LITERAL;
    }

    public function activeStatus() {
        return ($this->is_inactive) ? 'CANCELLED' : 'ACTIVE';
    }

    public function taxStatus() {
        return ($this->is_tax == 1) ? self::NON_TAX_LITERAL : self::TAX_LITERAL;
    }

    public function includeTaxStatus() {
        return ($this->is_include == 1) ? self::NON_INCLUDE_LITERAL : self::INCLUDE_TAX_LITERAL;
    }

    public function onHoldStatus() {
        switch ($this->is_hold) {
            case 1: return 'Cleared ';
            case 2: return 'On Hold ';
            case 3: return 'Canceled ';
            default: return 'N/A';
        }
    }

    public function searchByReceive() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT purchase.quantity_remaining
            FROM " . PurchaseDetail::model()->tableName() . " purchase
            WHERE t.id = purchase.purchase_header_id AND is_inactive = 0
            HAVING purchase.quantity_remaining > 0
            UNION ALL
            SELECT purchase.quantity_remaining
            FROM " . PurchaseNewProduct::model()->tableName() . " purchase
            WHERE t.id = purchase.purchase_header_id AND purchase.is_inactive = 0
            HAVING purchase.quantity_remaining > 0
        ) AND t.date > '2021-03-31' AND t.is_inactive = 0";

        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.order_header_id', $this->order_header_id);
        $criteria->compare('t.supplier_id', $this->supplier_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->purchaseDetails as $detail) {
            $total += $detail->total;
        }

        return $total;
    }

    public function getTotalNewProduct() {
        $total = 0.00;

        foreach ($this->purchaseNewProducts as $newProduct) {
            $total += $newProduct->total;
        }

        return $total;
    }

    public function getSubTotal() {
        $subTotal = $this->totalDetail + $this->totalNewProduct;

        if ((int) $this->is_tax === self::TAX && (int) $this->is_include === self::INCLUDE_TAX) {
            $subTotal = $subTotal / (1 + ($this->tax / 100));
        }

        return $subTotal;
    }

    public function getTotalTax() {

        return ((int) $this->is_tax === self::TAX) ? $this->subTotal * $this->tax / 100 : 0;
    }

    public function getGrandTotal() {
        return $this->subTotal + $this->totalTax;
    }

    public function getTotalReceipt() {
        $total = $this->totalDetail;

        foreach ($this->receiveHeaders as $receiveHeader) {
            foreach ($receiveHeader->purchaseReturnHeaders as $header) {
                $total -= $header->getGrandTotal($header->receive_header_id);
            }
        }

        return $total;
    }

    public static function makeChartAxisY($chartData, $part) {
        $total = 0;
        foreach ($chartData as $data) {
            if ($total < $data[1]) {
                $total = $data[1];
            }
        }

        $top = $total * (1 + 1 / ($part * 2));

        $n = 0;
        while (floor($top) >= 100) {
            $top /= 10;
            $n++;
        }

        $top = floor($top);

        $top += $part - $top % $part;

        for ($i = 0; $i < $n; $i++) {
            $top *= 10;
        }

        return array('min' => 0, 'max' => $top, 'tickSize' => floor($top / $part));
    }

    public static function makeChartAxisX($chartData) {
        $labels = array();
        foreach ($chartData as $data) {
            $labels[] = array($data[0], substr($data[2], 6, 8));
        }

        return array('min' => 0, 'max' => count($chartData) + 1, 'ticks' => $labels);
    }

    public static function makeChartData($backNum) {
        $data = array();
        $data['color'] = 'blue';
        $data['data'] = array();

        $dataRows = array();
        $dateList = array();
        for ($i = $backNum; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-{$i} months"));
            $dataRows[$date] = array('total' => 0);
            $dateList[] = $date;
        }

        $sql = "SELECT SUBSTRING(h.date, 1, 7) AS date, SUM(d.quantity * d.unit_price) AS total
                FROM tbldl_purchase_header h INNER JOIN tbldl_purchase_detail d ON h.id = d.purchase_header_id 
                WHERE SUBSTRING(h.date, 1, 7) <= :end AND SUBSTRING(h.date, 1, 7) >= :start
                GROUP BY SUBSTRING(h.date, 1, 7)";

        $rows = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(
            ':start' => $dateList[0],
            ':end' => $dateList[$backNum],
        ));

        foreach ($rows as $row) {
            if (in_array($row['date'], $dateList)) {
                $dataRows[$row['date']]['total'] = $row['total'];
            }
        }

        $counter = 1;
        foreach ($dataRows as $dateLiteral => $dataRow) {
            $tickLabel = date('M Y', strtotime($dateLiteral));
            $total = number_format($dataRow['total'], 2);
            $tooltip = "DATE: {$tickLabel}<br />TOTAL: {$total}";
            $data['data'][] = array($counter, $dataRow['total'], $tooltip);
            $counter++;
        }

        return $data;
    }

    public static function getMonthlyUserPurchaseReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS purchase_quantity, SUM(i.grand_total) AS purchase_total, 
                    COUNT(DISTINCT i.supplier_id) AS supplier_quantity
                FROM " . PurchaseHeader::model()->tableName() . " i
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
