<?php

class Delivery extends CComponent {

    public $header;
    public $details;
    public $newProducts;

    public function __construct($header, array $details, array $newProducts) {
        $this->header = $header;
        $this->details = $details;
        $this->newProducts = $newProducts;
    }

    public function addPackingList($packingListDetailId) {

        $exist = FALSE;
        $packingListDetail = PackingListDetail::model()->findByPk($packingListDetailId);

        if ($packingListDetail != null) {
            foreach ($this->details as $detail) {
                if ($detail->packing_list_detail_id == $packingListDetail->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new DeliveryDetail;
                $detail->order_detail_id = $packingListDetail->order_detail_id;
                $detail->packing_list_detail_id = $packingListDetailId;
                $detail->product_name = $packingListDetail->orderDetail->product_name;
                $detail->quantity = $packingListDetail->quantity;
                $detail->unit_id = $packingListDetail->orderDetail->unit_id;
                $this->details[] = $detail;
            }
        }
    }

    public function addReceive($orderNewProductId) {

        $exist = FALSE;
        $orderNewProduct = OrderNewProduct::model()->findByPk($orderNewProductId);

        if ($orderNewProduct != null) {
            foreach ($this->newProducts as $detail) {
                if ($detail->order_new_product_id == $orderNewProduct->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new DeliveryNewProduct;
                $detail->order_new_product_id = $orderNewProductId;
                $detail->product_name = $orderNewProduct->name;
                $detail->quantity = $orderNewProduct->quantity_receive_remaining;
                $this->newProducts[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function removeNewProductAt($index) {
        array_splice($this->newProducts, $index, 1);
    }

    public function updateProducts() {
        foreach ($this->details as $detail)
            $detail->getCurrentStock($this->header->warehouse_id);
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

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('product_name', 'quantity', 'order_detail_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }

        if (count($this->newProducts) > 0) {
            foreach ($this->newProducts as $detail) {
                $fields = array('product_name', 'quantity', 'order_new_product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }

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

    public function flush() {
        
        if (count($this->details) > 0) {
            $this->header->packing_list_header_id = $this->details[0]->packingListDetail->packing_list_header_id;
        }
        $valid = $this->header->save(false);

        Inventory::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->number,
            'transaction_type' => 3,
        ));

        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;

            if ($detail->isNewRecord)
                $detail->delivery_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
            
            $orderDetail = $detail->orderDetail;
            $orderDetail->quantity_delivery = $orderDetail->totalQuantityDelivery;
            $orderDetail->quantity_remaining = $orderDetail->quantity_single - $orderDetail->quantity_delivery;
            $valid = $orderDetail->update(array('quantity_delivery', 'quantity_remaining')) && $valid;

            if ((int) $detail->is_inactive == ActiveRecord::ACTIVE) {
                $transactionSubject = $this->header->orderHeader(array(
                    'with' => 'customer:resetScope',
                ))->customer->name;

                $inventory = new Inventory();
                $inventory->transaction_number = $this->header->number;
                $inventory->transaction_type = 3;
                $inventory->transaction_subject = $transactionSubject;
                $inventory->product_id = $detail->orderDetail->product_id;
                $inventory->unit_id = $detail->unit_id;
                $inventory->admin_id = $this->header->admin_id;
                $inventory->branch_id = $this->header->branch_id;
                $inventory->date = $this->header->date;
                $inventory->quantity_out = $detail->quantity;
                $inventory->price = $detail->orderDetail->product->movingAveragePrice;
                $inventory->warehouse_id = $this->header->warehouse_id;

                $valid = $inventory->save(false) && $valid;
            }
        }

        foreach ($this->newProducts as $detail) {
            if ($detail->quantity <= 0)
                continue;

            if ($detail->isNewRecord)
                $detail->delivery_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
            
            $orderNewProduct = $detail->orderNewProduct;
            $orderNewProduct->quantity_delivery = $orderNewProduct->totalQuantityDelivery;
            $orderNewProduct->quantity_remaining = $orderNewProduct->quantity - $orderNewProduct->quantity_delivery;
            $orderNewProduct->quantity_receive_remaining = $orderNewProduct->quantity_receive - $orderNewProduct->quantity_delivery;
            $valid = $orderNewProduct->update(array('quantity_delivery', 'quantity_remaining', 'quantity_receive_remaining')) && $valid;

        }
        return $valid;
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
                $total += $detail->quantity;
        }
        return $total;
    }

}