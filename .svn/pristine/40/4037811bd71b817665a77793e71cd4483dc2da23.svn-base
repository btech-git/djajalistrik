<?php

class PurchaseReturnHeader extends PurchaseReturnHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getGrandTotal($receiveHeaderId = null) {
        $totalDetail = 0.00;
        $totalNewProduct = 0.00;

        foreach ($this->purchaseReturnDetails as $detail) {
            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
                $totalDetail += $detail->getTotal($receiveHeaderId);
        }
        
        foreach ($this->purchaseReturnNewProducts as $detail) {
            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
                $totalNewProduct += $detail->getTotal($receiveHeaderId);
        }
        
        return $totalDetail + $totalNewProduct;
    }

    public function getSupplierCompany() {
        $receiveHeader = ReceiveHeader::model()->findByPk($this->receive_header_id);
        return empty($receiveHeader) ? "" : $receiveHeader->purchaseHeader->supplier->company;
    }
    
    public function getReceiveHeaderNumber() {
        $receiveHeader = ReceiveHeader::model()->findByPk($this->receive_header_id);
        return empty($receiveHeader) ? "" : $receiveHeader->number;        
    }
}