<?php

class Invoice extends InvoiceBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

//    public function searchBySaleReceipt() {
//        $criteria = new CDbCriteria;
//
//        $criteria->condition = "
//            t.id NOT IN (
//                SELECT invoice_id 
//                FROM " . SaleReceiptDetail::model()->tableName() . "
//                WHERE is_inactive = 0                
//            )
//        ";
//
//        $criteria->compare('number', $this->number, true);
//        $criteria->compare('date', $this->date, true);
//        $criteria->compare('delivery_header_id', $this->delivery_header_id);
//        $criteria->compare('reference', $this->reference, true);
//
//        return new CActiveDataProvider(get_class($this), array(
//            'criteria' => $criteria,
//        ));
//    }

    public function searchBySalePayment() {
        $criteria = new CDbCriteria;

        $criteria->order = 't.id DESC';
        $criteria->condition = "EXISTS (
			SELECT h.grand_total - h.total_payment AS remaining 
			FROM " . Invoice::model()->tableName() . " h 
			WHERE t.id = h.id
			HAVING remaining > 0
		)";

        $criteria->compare('number', $this->number, true);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalDetail() {
        return ($this->deliveryHeader === null) ? 0.00 : $this->deliveryHeader->grandTotal;
    }

    public function getRemaining() {
        return $this->grand_total - $this->total_payment;
    }

}