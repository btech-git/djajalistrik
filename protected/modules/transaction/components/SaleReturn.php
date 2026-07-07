<?php

class SaleReturn extends CComponent {

    public $header;
    public $details;
    public $newProducts;

    public function __construct($header, array $details, array $newProducts) {
        $this->header = $header;
        $this->details = $details;
        $this->newProducts = $newProducts;
    }

    public function addDetail($id) {
        $sql = "SELECT p.id, p.unit_id, o.unit_price_single, p.quantity - p.quantity_return AS remaining
                FROM " . DeliveryDetail::model()->tableName() . " p
                INNER JOIN " . OrderDetail::model()->tableName() . " o ON o.id = p.order_detail_id
                WHERE p.delivery_header_id = :delivery_header_id
                HAVING remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':delivery_header_id' => $id));
        $this->details = array();

        foreach ($resultSet as $row) {
            $detail = new SaleReturnDetail();

            $detail->delivery_detail_id = $row['id'];
            $detail->unit_id = $row['unit_id'];
            $detail->unit_price = $row['unit_price_single'];
            $detail->quantity = 0;

            $this->details[] = $detail;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function addNewProduct($id) {
        $sql = "SELECT p.id, o.unit_price, p.quantity - p.quantity_return AS remaining
                FROM " . DeliveryNewProduct::model()->tableName() . " p
                INNER JOIN " . OrderNewProduct::model()->tableName() . " o ON o.id = p.order_new_product_id
				WHERE p.delivery_header_id = :delivery_header_id
				HAVING remaining > 0";

        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(':delivery_header_id' => $id));
        $this->newProducts = array();

        foreach ($resultSet as $row) {
            $detail = new SaleReturnNewProduct();

            $detail->delivery_new_product_id = $row['id'];
            $detail->unit_price = $row['unit_price'];
            $detail->quantity = 0;

            $this->newProducts[] = $detail;
        }
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
            'transaction_type' => 4,
        ));

        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;
            
            if ($detail->isNewRecord)
                $detail->sale_return_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;

            if ((int) $detail->is_inactive === ActiveRecord::ACTIVE) {
                $transactionSubject = $this->header->deliveryHeader->orderHeader(array(
                    'with' => 'customer:resetScope',
                ))->customer->company;

                $inventory = new Inventory();
                $inventory->transaction_number = $this->header->number;
                $inventory->transaction_type = 4;
                $inventory->transaction_subject = ($transactionSubject === null) ? '' : $transactionSubject;
                $inventory->product_id = $detail->deliveryDetail->orderDetail->product_id;
                $inventory->unit_id = $detail->unit_id;
                $inventory->admin_id = $this->header->admin_id;
                $inventory->branch_id = $this->header->branch_id;
                $inventory->date = $this->header->date;
                $inventory->quantity_in = $detail->quantity;
                $inventory->warehouse_id = $this->header->warehouse_id;
                $inventory->price = $detail->deliveryDetail->orderDetail->product->movingAveragePrice;

                $valid = $inventory->save(false) && $valid;
                
                $deliveryDetail = $detail->deliveryDetail;
                $deliveryDetail->quantity_return = $deliveryDetail->totalQuantityReturn;
                $valid = $deliveryDetail->update(array('quantity_return')) && $valid;

            }
        }
        
        foreach ($this->newProducts as $newProduct) {
            if ($newProduct->quantity <= 0)
                continue;
            
            if ($newProduct->isNewRecord)
                $newProduct->sale_return_header_id = $this->header->id;

            $valid = $newProduct->save(false) && $valid;

            if ((int) $newProduct->is_inactive === ActiveRecord::ACTIVE) {
                $deliveryNewProduct = $newProduct->deliveryNewProduct;
                $deliveryNewProduct->quantity_return = $deliveryNewProduct->totalQuantityReturn;
                $valid = $deliveryNewProduct->update(array('quantity_return')) && $valid;
            }
        }
        
        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

//        $valid = $this->validateDetailsCount() && $valid;
//		$valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'delivery_detail_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
//        else
//            $valid = false;

        if (count($this->newProducts) > 0) {
            foreach ($this->newProducts as $detail) {
                $fields = array('quantity', 'delivery_new_product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
//        else
//            $valid = false;

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

//	public function validateDetailsUnique()
//	{
//		$valid = true;
//		
//		$detailsCount = count($this->details);
//		for ($i = 0; $i < $detailsCount; $i++)
//		{
//			for ($j = $i; $j < $detailsCount; $j++)
//			{
//				if ($i === $j) continue;
//				
//				if ($this->details[$i]->product_id === $this->details[$j]->product_id)
//				{
//					$valid = false;
//					$this->header->addError('error', 'Nama Produk tidak boleh sama.');
//					break;
//				}
//			}
//		}
//
//		return $valid;
//	}

    public function getGrandTotal() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            if ((int)$detail->is_inactive === ActiveRecord::ACTIVE)
                $total += $detail->getTotal();
        }
        return $total;
    }

    public function getGrandTotalNewProduct() {
        $total = 0.00;

        foreach ($this->newProducts as $detail) {
            if ((int)$detail->is_inactive === ActiveRecord::ACTIVE)
                $total += $detail->getTotal();
        }
        return $total;
    }
}
