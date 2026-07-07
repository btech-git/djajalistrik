<?php

class Customer extends CustomerBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalSales() {
        $totalSales = 0.00;

        foreach ($this->orderHeaders as $orderHeader) {
            $totalSales += $orderHeader->grandTotal;
        }

        return $totalSales;
    }

    public function getRemainingCreditLimit() {
        $totalRemaining = 0.00;

        foreach ($this->invoiceHeaders as $invoiceHeader) {
            $totalRemaining += $invoiceHeader->remaining;
        }

        return $this->credit_limit - $totalRemaining;
    }

}
