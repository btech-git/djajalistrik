<?php

class Receive extends CComponent {

    public $header;
    public $details;
    public $newProducts;

    public function __construct($header, array $details, array $newProducts) {
        $this->header = $header;
        $this->details = $details;
        $this->newProducts = $newProducts;
    }

    public function addDetailByPurchase($id) {
        $sql = "SELECT p.id, p.product_id, p.quantity_remaining, p.unit_id
                FROM " . PurchaseDetail::model()->tableName() . " p
                WHERE p.purchase_header_id = :purchase_id AND p.is_inactive = 0
                HAVING p.quantity_remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':purchase_id' => $id));

        $this->details = array();

        foreach ($resultSet as $row) {
            $detail = new ReceiveDetail();

            $detail->purchase_detail_id = $row['id'];
            $detail->product_id = $row['product_id'];
            $detail->quantity_order = $row['quantity_remaining'];
            $detail->quantity_receive = 0;
            $detail->unit_id = $row['unit_id'];

            $this->details[] = $detail;
        }
    }

    public function addNewProductByPurchase($id) {
        $sql = "SELECT p.id, p.order_new_product_id, p.quantity_remaining
                FROM " . PurchaseNewProduct::model()->tableName() . " p
                WHERE p.purchase_header_id = :purchase_id AND p.is_inactive = 0
                HAVING p.quantity_remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':purchase_id' => $id));

        $this->newProducts = array();

        foreach ($resultSet as $row) {
            $newProduct = new ReceiveNewProduct();
            $newProduct->purchase_new_product_id = $row['id'];
            $newProduct->order_new_product_id = $row['order_new_product_id'];
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
        $this->header->reference = empty($this->header->purchaseHeader->order_header_id) ? '' : $this->header->purchaseHeader->orderHeader->reference_number;
        $valid = $this->header->save(false);

        Inventory::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->number,
            'transaction_type' => 1,
        ));

        foreach ($this->details as $detail) {
            if ($detail->quantity_receive <= 0)
                continue;

            if ($detail->isNewRecord)
                $detail->receive_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;

            $purchaseDetail = $detail->purchaseDetail;
            $purchaseDetail->quantity_receive = $purchaseDetail->totalQuantityReceive;
            $purchaseDetail->quantity_remaining = $purchaseDetail->quantity - $purchaseDetail->quantity_receive;
            $valid = $purchaseDetail->update(array('quantity_receive', 'quantity_remaining')) && $valid;

            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE) {
                $transactionSubject = $this->header->purchaseHeader(array(
                    'scopes' => 'resetScope',
                    'with' => array(
                        'with' => 'supplier:resetScope',
                    )
                ))->supplier->company;

                $inventory = new Inventory();
                $inventory->transaction_number = $this->header->number;
                $inventory->transaction_type = 1;
                $inventory->transaction_subject = $transactionSubject;
                $inventory->product_id = $detail->product_id;
                $inventory->unit_id = $detail->unit_id;
                $inventory->admin_id = $this->header->admin_id;
                $inventory->branch_id = $this->header->branch_id;
                $inventory->date = $this->header->date;
                $inventory->quantity_in = $detail->quantity_receive;
                $inventory->price = $detail->product->movingAveragePrice;
                $inventory->warehouse_id = $this->header->warehouse_id;

                $valid = $inventory->save(false) && $valid;
            }
        }

        foreach ($this->newProducts as $newProduct) {
            if ($newProduct->quantity <= 0)
                continue;

            if ($newProduct->isNewRecord)
                $newProduct->receive_header_id = $this->header->id;

            $valid = $newProduct->save(false) && $valid;
            
            $purchaseNewProduct = $newProduct->purchaseNewProduct;
            $purchaseNewProduct->quantity_receive = $purchaseNewProduct->totalQuantityReceive;
            $purchaseNewProduct->quantity_remaining = $purchaseNewProduct->quantity - $purchaseNewProduct->quantity_receive;
            $valid = $purchaseNewProduct->update(array('quantity_receive', 'quantity_remaining')) && $valid;
            
            $orderNewProduct = $newProduct->purchaseNewProduct->orderNewProduct;
            if (!empty($orderNewProduct)) {
                $orderNewProduct->quantity_receive = $orderNewProduct->totalQuantityReceive;
                $orderNewProduct->quantity_receive_remaining = $orderNewProduct->quantity_receive - $orderNewProduct->quantity_delivery;
                $valid = $orderNewProduct->update(array('quantity_receive', 'quantity_receive_remaining')) && $valid;
            }
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

//        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0 || count($this->newProducts) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'product_id', 'quantity_remaining', 'quantity_receive');
                $valid = $detail->validate($fields) && $valid;
            }

            foreach ($this->newProducts as $newProduct) {
                $fields = array('quantity', 'purchase_new_product_id', 'quantity_remaining', 'quantity_receive');
                $valid = $newProduct->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

//    public function validateDetailsCount() {
//        $valid = true;
//        if (count($this->details) === 0) {
//            $valid = false;
//            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
//        }
//
//        return $valid;
//    }

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
}