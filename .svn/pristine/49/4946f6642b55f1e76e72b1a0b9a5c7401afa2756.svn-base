<?php

class OrderNewProduct extends OrderNewProductBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDiscountValue() {
        return ((((((1 + ($this->discount_1 / 100))) * (1 + ($this->discount_2 / 100))) * (1 + ($this->discount_3 / 100))) * (1 + ($this->discount_4 / 100))) * (1 + ($this->discount_5 / 100)));
    }

    public function getPriceAfterDiscount() {
        return $this->unit_price * $this->discountValue;
    }
    
    public function getTotal() {
        return ((((($this->quantity * $this->unit_price * (1 + $this->discount_1 / 100)) * (1 + $this->discount_2 / 100)) * (1 + $this->discount_3 / 100)) * (1 + $this->discount_4 / 100)) * (1 + $this->discount_5 / 100));
    }

    public function getTotalQuantityDelivery() {
        $total = 0;

        foreach ($this->deliveryNewProducts as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }

    public function getTotalQuantityPurchase() {
        $total = 0;

        foreach ($this->purchaseNewProducts as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }
    
    public function getTotalQuantityReceive() {
        $total = 0;

        foreach ($this->receiveNewProducts as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }
    
    public function getTotalQuantityInvoice() {
        $total = 0;

        foreach ($this->deliveryNewProducts as $delivery) {
            foreach ($delivery->invoiceNewProducts as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        return $total;
    }
    
    public function searchForDelivery() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.quantity_receive_remaining > 0";

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('order_header_id', $this->order_header_id);
        $criteria->compare('quantity_delivery', $this->quantity_delivery);
        $criteria->compare('quantity_remaining', $this->quantity_remaining);
        $criteria->compare('quantity_receive', $this->quantity_receive);
        $criteria->compare('quantity_receive_remaining', $this->quantity_receive_remaining);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}