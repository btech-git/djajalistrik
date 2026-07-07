<?php

class PurchasePayment extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function addDetail() {
        $detail = new PurchasePaymentDetail();

        $this->details[] = $detail;
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function resetPayment() {
        $this->details = array();
        $this->details[] = new PurchasePaymentDetail();
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->amount <= 0)
                continue;

            if ($this->header->isNewRecord)
                $detail->purchase_payment_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
        }

        $purchaseReceiptHeader = $this->header->purchaseReceiptHeader(array('scopes' => 'resetScope'));
        $purchaseReceiptHeader->payment_total = $purchaseReceiptHeader->totalPayment;
        $valid = $purchaseReceiptHeader->update(array('payment_total')) && $valid;

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if ($this->header->isNewRecord) {
            $valid = $this->validatePayment() && $valid;
        }
        
        $valid = $this->validateDetailsCount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('amount', 'payment_type_id', 'memo');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function validatePayment() {
        $valid = true;
        
        if ($this->totalPayment > $this->totalPurchase) {
            $valid = false;
            $this->header->addError('error', 'Nominal Pembayaran lebih besar dari total.');
        }
        
        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function getTotalPurchase() {
        return ($this->header->purchaseReceiptHeader === null) ? 0.00 : $this->header->purchaseReceiptHeader->remaining;
    }

    public function getTotalPayment() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->amount;

        return $total;
    }

    public function getRemaining() {
        return $this->totalPurchase - $this->totalPayment;
    }

}
