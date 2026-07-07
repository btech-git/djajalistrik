<?php

class PurchaseNewProduct extends PurchaseNewProductBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDiscountNominal() {
        
        $discount1 = $this->unit_price * $this->discount_1 / 100;
        $discount2 = $discount1 * $this->discount_2 / 100;
        $discount3 = $discount2 * $this->discount_3 / 100;
        $discount4 = $discount3 * $this->discount_4 / 100;
        $discount5 = $discount4 * $this->discount_5 / 100;
        $totalDiscount = $discount1 + $discount2 + $discount3 + $discount4 + $discount5;
        
        return $totalDiscount;
    }

    public function getPriceAfterDiscount() {
        return ((((($this->unit_price * (1 + $this->discount_1 / 100)) * (1 + $this->discount_2 / 100)) * (1 + $this->discount_3 / 100)) * (1 + $this->discount_4 / 100)) * (1 + $this->discount_5 / 100));
    }

    public function getTotal() {
        return $this->quantity * $this->priceAfterDiscount;
    }

    public function getTotalQuantityReceive() {
        $total = 0;
        
        foreach($this->receiveNewProducts as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }
        
        return $total;
    }

    public function searchForSummary() {
        $criteria = new CDbCriteria;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalQuantityReturn() {
        $total = 0;

        foreach ($this->receiveNewProducts as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->totalQuantityReturn;
            }
        }

        return $total;
    }
}