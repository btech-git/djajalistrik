<?php

class Purchase extends CComponent {

    public $header;
    public $details;
    public $newProducts;

    public function __construct($header, array $details, array $newProducts) {
        $this->header = $header;
        $this->details = $details;
        $this->newProducts = $newProducts;
    }

    public function addDetailByOrder($id) {
        $sql = "SELECT o.id, o.product_id, o.unit_id, o.unit_price_after_discount, o.quantity_single - o.quantity_purchase AS remaining
                FROM " . OrderDetail::model()->tableName() . " o
                WHERE o.order_header_id = :order_id AND o.is_inactive = 0
                HAVING remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':order_id' => $id));

        $this->details = array();
        $order = OrderHeader::model()->findByPk($id);

        if ($order !== null) {
//            $exist = false;

            foreach ($resultSet as $row) {
                $detail = new PurchaseDetail();
                $detail->product_id = $row['product_id'];
                $detail->unit_id = $row['unit_id'];
                $detail->order_detail_id = $row['id'];
                $detail->unit_price_sale_order = $row['unit_price_after_discount'];
                $this->details[] = $detail;
            }
        }
    }

    public function addNewProductByOrder($id) {
        $sql = "SELECT o.id, o.name, o.unit_id, o.unit_price_after_discount, o.quantity - o.quantity_purchase AS remaining
                FROM " . OrderNewProduct::model()->tableName() . " o
                WHERE o.order_header_id = :order_id AND o.is_inactive = 0
                HAVING remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':order_id' => $id));

        $this->newProducts = array();
        $order = OrderHeader::model()->findByPk($id);

        if ($order !== null) {
//            $exist = false;

            foreach ($resultSet as $row) {
                $detail = new PurchaseNewProduct();
                $detail->product_name = $row['name'];
                $detail->unit_id = $row['unit_id'];
                $detail->order_new_product_id = $row['id'];
                $detail->unit_price_sale_order = $row['unit_price_after_discount'];
                $this->newProducts[] = $detail;
            }
        }
    }

    public function addDetail($id) {
        $product = Product::model()->findByPk($id);

        if ($product !== null) {
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($product->id === $detail->product_id) {
                    $exist = true;
                    break;
                }
            }
            if ($exist)
                $this->details[$i]->quantity++;
            else {
                $detail = new PurchaseDetail();
                $detail->product_id = $product->id;
                $detail->unit_id = $product->unit_id_single;
                $detail->unit_price = $product->selling_price;

                $this->details[] = $detail;
            }
        }
    }

    public function addNewProduct() {
        $newProduct = new PurchaseNewProduct();

        $this->newProducts[] = $newProduct;
    }

    public function updateTax() {
        if ($this->header->is_include === 0)
            $this->header->totalTax;
    }

    public function resetDetail() {
        $this->details = array();
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

    public function validate() {
        $valid = $this->header->validate();

        if ($this->header->orderHeader !== null && $this->header->isNewRecord) {
            if (count($this->newProducts) > 0) {
                $valid = $this->validateQuantityToOrder() && $valid;
            }
        }

        if (count($this->details) > 0) {
            if (!empty($this->header->order_header_id)) {
                $valid = $this->validateDetailsPricing() && $valid;
            }
            
            if (!$this->header->isNewRecord) {
                $valid = $this->validateDetailsInactive() && $valid;
            }
        }

        if (count($this->newProducts) > 0) {
            if (!empty($this->header->order_header_id)) {
                $valid = $this->validateNewProductsPricing() && $valid;
            }
            
            if (!$this->header->isNewRecord) {
                $valid = $this->validateNewProductsInactive() && $valid;                
            }
        }

//		if (count($this->details) > 0)
//		{
//			foreach ($this->details as $detail)
//			{
//				$fields = array('quantity', 'unit_price', 'product_id');
//				$valid = $detail->validate($fields) && $valid;
//			}
//
//			$valid = $this->validateDetailPrices() && $valid;
//		}

        return $valid;
    }

    public function validateDetailsInactive() {
        $valid = true;

        foreach ($this->details as $detail) {
            $receiveDetail = ReceiveDetail::model()->findByAttributes(array('purchase_detail_id' => $detail->id, 'is_inactive' => ActiveRecord::ACTIVE));
            if (!empty($receiveDetail) && $detail->is_inactive == ActiveRecord::INACTIVE) {
                $valid = false;
                $this->header->addError('error', 'Detail tidak dapat di inactive');
                break;
            }
        }

        return $valid;
    }

    public function validateNewProductsInactive() {
        $valid = true;

        foreach ($this->newProducts as $detail) {
            $receiveNewProduct = ReceiveNewProduct::model()->findByAttributes(array('purchase_new_product_id' => $detail->id, 'is_inactive' => ActiveRecord::ACTIVE));
            if (!empty($receiveNewProduct) && $detail->is_inactive == ActiveRecord::INACTIVE) {
                $valid = false;
                $this->header->addError('error', 'Detail tidak dapat di inactive');
                break;
            }
        }

        return $valid;
    }

    public function validateQuantityToOrder() {
        $valid = true;

        foreach ($this->newProducts as $detail) {
            if ($detail->quantity > ($detail->orderNewProduct->quantity - $detail->orderNewProduct->quantity_purchase)) {
                $valid = false;
                $this->header->addError('error', 'Quantity order melebihi pesanan customer!!!');
                break;
            }
        }

        return $valid;
    }

    public function validateNewProductsPricing() {
        $valid = true;

        $detailsCount = count($this->newProducts);
        for ($i = 0; $i < $detailsCount; $i++) {
            if ($this->newProducts[$i]->unit_price_sale_order < $this->newProducts[$i]->priceAfterDiscount) {
                $valid = false;
                $this->header->addError('error', 'Harga Beli Lebih Besar Dari Harga Jual');
                break;
            }
        }

        return $valid;
    }
    
    public function validateDetailsPricing() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            if ($this->details[$i]->unit_price_sale_order < $this->details[$i]->priceAfterDiscount) {
                $valid = false;
                $this->header->addError('error', 'Harga Beli Lebih Besar Dari Harga Jual');
                break;
            }
        }

//        if ($this->header->orderHeader !== null) {
//            foreach ($this->details as $i => $detail) {
//                $orderDetail = OrderDetail::model()->findByAttributes(array(
//                    'order_header_id' => $this->header->order_header_id,
//                    'product_id' => $detail->product_id,
//                    'unit_id' => $detail->unit_id,
//                ));
//
//                if ($orderDetail === null) {
//                    $valid = false;
//                    break;
//                }
//
//                if ($orderDetail->priceAfterDiscount < $detail->priceAfterDiscount) {
//                    $valid = false;
//                    $detail->addError('unit_price', 'Harga satuan lebih besar dari Harga Satuan SO');
//                }
//            }
//        }

        return $valid;
    }

    public function flush() {
        $this->header->tax = (int) $this->header->is_tax == 0 ? 11 : 0;
        $this->header->customer_id = empty($this->header->order_header_id) ? null : $this->header->orderHeader->customer_id;
        $this->header->grand_total = $this->grandTotal;
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $detail->purchase_header_id = $this->header->id;
                $detail->quantity_remaining = $detail->quantity;

                if ($detail->quantity <= 0)
                    continue;
            }
            $detail->unit_price_after_discount = $detail->getPriceAfterDiscount();

            $valid = $detail->save(false) && $valid;

            $orderDetail = $detail->orderDetail;
            if (!empty($orderDetail)) {
                $orderDetail->quantity_purchase = $orderDetail->totalQuantityPurchase;
                $valid = $orderDetail->update(array('quantity_purchase')) && $valid;
            }
        }

        foreach ($this->newProducts as $newProduct) {
            if ($newProduct->quantity <= 0)
                continue;

            if ($newProduct->isNewRecord) {
                $newProduct->purchase_header_id = $this->header->id;
                $newProduct->quantity_remaining = $newProduct->quantity;
            }
            $newProduct->unit_price_after_discount = $newProduct->getPriceAfterDiscount();

            $valid = $newProduct->save(false) && $valid;

            $orderNewProduct = $newProduct->orderNewProduct;
            if (!empty($orderNewProduct)) {
                $orderNewProduct->quantity_purchase = $orderNewProduct->totalQuantityPurchase;
                $valid = $orderNewProduct->update(array('quantity_purchase')) && $valid;
            }
        }

        return $valid;
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
                $total += $detail->total;
        }

        return $total;
    }

    public function getTotalNewProduct() {
        $total = 0.00;

        foreach ($this->newProducts as $newProduct) {
            if ((int) $newProduct->is_inactive === ActiveRecord::ACTIVE)
                $total += $newProduct->total;
        }

        return $total;
    }

    public function getSubTotal() {
        $subTotal = 0.00;

        if ((int) $this->header->is_tax === 0 && (int) $this->header->is_include === 0)
            $subTotal = ($this->totalDetail + $this->totalNewProduct) / 1.11;
        else
            $subTotal = $this->totalDetail + $this->totalNewProduct;

        return $subTotal;
    }

    public function getTotalTax() {
//        if ((int) $this->header->is_tax === 0 && (int) $this->header->is_include === 0)
//            $taxValue = $this->grandTotal / 1.1 * .1;
//        elseif ((int) $this->header->is_tax === 0 && (int) $this->header->is_include === 1)
//            $taxValue = $this->subTotal * .1;
//        else
//            $taxValue = 0.00;

        return (int) $this->header->is_tax == 0 ? $this->subTotal * .11 : 0;
    }

    public function getGrandTotal() {
//        $grandTotal = 0.00;
//
//        if ((int) $this->header->is_tax === 0 && (int) $this->header->is_include === 1)
//            $grandTotal = $this->subTotal + $this->totalTax;
//        else if ((int) $this->header->is_tax === 1 || (int) $this->header->is_include === 0)
//            $grandTotal = $this->totalDetail + $this->totalNewProduct;

        return $this->subTotal + $this->totalTax;
    }

}
