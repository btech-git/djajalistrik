<?php

class PurchaseReturn extends CComponent {

    public $header;
    public $details;
    public $newProducts;

    public function __construct($header, array $details, array $newProducts) {
        $this->header = $header;
        $this->details = $details;
        $this->newProducts = $newProducts;
    }

    public function addDetail($id) {
        $sql = "SELECT p.id, p.product_id, p.unit_id, p.quantity_receive - p.quantity_return AS remaining
                FROM " . ReceiveDetail::model()->tableName() . " p
                WHERE p.receive_header_id = :receive_header_id
                HAVING remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':receive_header_id' => $id));

        $this->details = array();

        foreach ($resultSet as $row) {
            $detail = new PurchaseReturnDetail();

            $detail->receive_detail_id = $row['id'];
            $detail->product_id = $row['product_id'];
            $detail->unit_id = $row['unit_id'];
            $detail->quantity = 0;

            $this->details[] = $detail;
        }
    }

    public function addNewProduct($id) {
        $sql = "SELECT p.id, p.quantity - p.quantity_return AS remaining
                FROM " . ReceiveNewProduct::model()->tableName() . " p
				WHERE p.receive_header_id = :receive_header_id
				HAVING remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':receive_header_id' => $id));

        $this->newProducts = array();

        foreach ($resultSet as $row) {
            $newProduct = new PurchaseReturnNewProduct();
            $newProduct->receive_new_product_id = $row['id'];
            $newProduct->quantity = 0;
            $this->newProducts[] = $newProduct;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function removeNewProductAt($index) {
        array_splice($this->newProducts, $index, 1);
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

        Inventory::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->number,
            'transaction_type' => 2,
        ));

        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;
            if ($detail->isNewRecord)
                $detail->purchase_return_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;

            $receiveDetail = $detail->receiveDetail;
            $receiveDetail->quantity_return = $receiveDetail->totalQuantityReturn;
            $valid = $receiveDetail->update(array('quantity_return')) && $valid;

            $purchaseDetail = $receiveDetail->purchaseDetail;
            $purchaseDetail->quantity_return = $purchaseDetail->totalQuantityReturn;
            $purchaseDetail->quantity_remaining = $purchaseDetail->quantity - $purchaseDetail->quantity_receive - $purchaseDetail->quantity_return;
            $valid = $purchaseDetail->update(array('quantity_return', 'quantity_remaining')) && $valid;

            $orderDetail = $purchaseDetail->orderDetail;
            $orderDetail->quantity_purchase = $purchaseDetail->quantity - $purchaseDetail->quantity_return;
            $valid = $orderDetail->update(array('quantity_purchase')) && $valid;

            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE) {
                $transactionSubject = $this->header->receiveHeader->purchaseHeader->supplier->company;

                $inventory = new Inventory();
                $inventory->transaction_number = $this->header->number;
                $inventory->transaction_type = 2;
                $inventory->transaction_subject = $transactionSubject;
                $inventory->product_id = $detail->product_id;
                $inventory->unit_id = $detail->unit_id;
                $inventory->admin_id = $this->header->admin_id;
                $inventory->branch_id = $this->header->branch_id;
                $inventory->date = $this->header->date;
                $inventory->quantity_out = $detail->quantity;
                $inventory->price = $detail->product->movingAveragePrice;
                $inventory->warehouse_id = $this->header->warehouse_id;

                $valid = $inventory->save(false) && $valid;
            }
        }
        
        foreach ($this->newProducts as $detail) {
            if ($detail->quantity <= 0)
                continue;
            
            if ($detail->isNewRecord)
                $detail->purchase_return_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
            
            $receiveNewProduct = $detail->receiveNewProduct;
            $receiveNewProduct->quantity_return = $receiveNewProduct->totalQuantityReturn;
            $valid = $receiveNewProduct->update(array('quantity_return')) && $valid;

            $purchaseNewProduct = $receiveNewProduct->purchaseNewProduct;
            $purchaseNewProduct->quantity_return = $purchaseNewProduct->totalQuantityReturn;
            $purchaseNewProduct->quantity_remaining = $purchaseNewProduct->quantity - $purchaseNewProduct->quantity_receive - $purchaseNewProduct->quantity_return;
            $valid = $purchaseNewProduct->update(array('quantity_return', 'quantity_remaining')) && $valid;

            $orderNewProduct = $purchaseNewProduct->orderNewProduct;
            $orderNewProduct->quantity_purchase = $purchaseNewProduct->quantity - $purchaseNewProduct->quantity_return;
            $valid = $orderNewProduct->update(array('quantity_purchase')) && $valid;

        }
        
        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

//        $valid = $this->validateDetailsCount() && $valid;
//        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        
        if (count($this->newProducts) > 0) {
            foreach ($this->newProducts as $detail) {
                $fields = array('quantity', 'receive_new_product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
//        else
//            $valid = false;

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

                if ($this->details[$i]->product_id === $this->details[$j]->product_id) {
                    $valid = false;
                    $this->header->addError('error', 'Nama Produk tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function getGrandTotal($receiveHeaderId = null) {
        $totalDetail = 0.00;
        $totalNewProduct = 0.00;

        foreach ($this->details as $detail) {
            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
                $totalDetail += $detail->getTotal($receiveHeaderId);
        }
        
        foreach ($this->newProducts as $detail) {
            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
                $totalNewProduct += $detail->getTotal($receiveHeaderId);
        }
        
        return $totalDetail + $totalNewProduct;
    }

}
