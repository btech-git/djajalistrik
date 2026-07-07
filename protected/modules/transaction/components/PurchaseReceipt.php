<?php

class PurchaseReceipt extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function addDetail($id) {
        $receiveHeader = ReceiveHeader::model()->findByPk($id);

        if ($receiveHeader !== null) {
            $exist = false;
            
            foreach ($this->details as $i => $detail) {
                if ($receiveHeader->id === $detail->receive_header_id) {
                    $exist = true;
                    break;
                }
            }

            if ($receiveHeader->purchaseHeader->supplier_id !== $this->header->supplier_id)
                $exist = true;

            if (!$exist) {
                $detail = new PurchaseReceiptDetail();
                $detail->receive_header_id = $id;
                $detail->amount = $receiveHeader->grandTotal;
                $detail->tax_number = $receiveHeader->purchaseHeader->is_tax == 0 ? '000-00.000-000': '';
                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function resetDetail() {
        $this->details = array();
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
        $this->header->grand_total = $this->totalPurchase;
        $valid = $this->header->save(false);
        
        foreach ($this->details as $detail) {
            if ($detail->isNewRecord)
                $detail->purchase_receipt_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('receive_header_id', 'amount');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->receive_header_id === $this->details[$j]->receive_header_id) {
                    $valid = false;
                    $this->header->addError('error', 'Pembelian tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function getTotalPurchase() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += ($detail->receiveHeader === null) ? 0.00 : $detail->receiveHeader->grandTotal;
        }

        return $total;
    }
}
