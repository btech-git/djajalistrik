<?php

class Adjustment extends CComponent
{
	public $header;
	public $details;

	public function __construct($header, array $details)
	{
		$this->header = $header;
		$this->details = $details;
	}

	public function updateProducts() {
        foreach ($this->details as $detail)
            $detail->quantity_current = $detail->product->getStock($this->header->warehouse_id);
    }

    public function removeDetailAt($index)
	{
		array_splice($this->details, $index, 1);
	}

	public function save($dbConnection)
	{
		$dbTransaction = $dbConnection->beginTransaction();
		try
		{
			$valid = $this->validate() && $this->flush();
			if ($valid)
				$dbTransaction->commit();
			else
				$dbTransaction->rollback();
		}
		catch (Exception $e)
		{
			$dbTransaction->rollback();
			$valid = false;
		}

		return $valid;
	}

	public function validate()
	{
		$valid = $this->header->validate();
		
		$valid = $this->validateDetailsCount() && $valid;
		$valid = $this->validateDetailsUnique() && $valid;

		if (count($this->details) > 0)
		{
			foreach ($this->details as $detail)
			{
				$fields = array('quantity_current', 'quantity_adjustment', 'product_id');
				$valid = $detail->validate($fields) && $valid;
			}
		}
		else
			$valid = false;

		return $valid;
	}
	
	public function validateDetailsCount()
	{
		$valid = true;
		if (count($this->details) === 0)
		{
			$valid = false;
			$this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
		}
		
		return $valid;
	}

	public function validateDetailsUnique()
	{
		$valid = true;
		
		$detailsCount = count($this->details);
		for ($i = 0; $i < $detailsCount; $i++)
		{
			for ($j = $i; $j < $detailsCount; $j++)
			{
				if ($i === $j) continue;
				
				if ($this->details[$i]->product_id === $this->details[$j]->product_id)
				{
					$valid = false;
					$this->header->addError('error', 'Nama Produk tidak boleh sama.');
					break;
				}
			}
		}

		return $valid;
	}

//	public function flush()
//	{
//		$valid = $this->header->save(false);
//		foreach ($this->details as $detail)
//		{
//			if ($detail->quantity_adjustment <= 0)
//				continue;
//
//			if ($detail->isNewRecord)
//				$detail->adjustment_header_id = $this->header->id;
//
//			$valid = $detail->save(false) && $valid;
//
//			$inventoryFound = Inventory::model()->findByAttributes(array(
//				'transaction_number' => $this->header->number,
//				'product_id' => $detail->product_id,
//				'branch_id' => $this->header->branch_id,
//				'transaction_type' => 5,
//				));
//
//			if ($inventoryFound === null)
//			{
//				$inventory = new Inventory();
//				$inventory->transaction_number = $this->header->number;
//				$inventory->transaction_type = 5;
//				$inventory->transaction_subject = 'adjustment';
//				$inventory->product_id = $detail->product_id;
//				$inventory->unit_id = $detail->unit_id;
//				$inventory->admin_id = $this->header->admin_id;
//				$inventory->branch_id = $this->header->branch_id;
//			}
//			else
//				$inventory = $inventoryFound;
//
//			$inventory->date = $this->header->date;
//			$inventory->quantity_in = $detail->quantity_adjustment - $detail->quantity_current;
//			$inventory->warehouse_id = $this->header->warehouse_id;
//
//			$valid = $inventory->save(false) && $valid;
//		}
//
//		return $valid;
//	}
	
	public function flush()
	{
		$valid = $this->header->save(false);
		
			
		Inventory::model()->deleteAllByAttributes(array(
			'transaction_number' => $this->header->number,
			'transaction_type' => 5,
		));

		foreach ($this->details as $detail)
		{
			if($detail->quantity_adjustment <=0) continue;

			if ($detail->isNewRecord)
				$detail->adjustment_header_id = $this->header->id;

			$valid = $detail->save(false) && $valid;

			$inventoryFound = Inventory::model()->findByAttributes(array(
				'transaction_number' => $this->header->number,
				'product_id' => $detail->product_id,
				'branch_id' => $this->header->branch_id,
				'transaction_type' => 5,
			));

			if ($inventoryFound === null)
			{
				$inventory = new Inventory();
				$inventory->transaction_number = $this->header->number;
				$inventory->transaction_type = 5;
				$inventory->transaction_subject ='adjustment';
				$inventory->product_id = $detail->product_id;
				$inventory->admin_id = $this->header->admin_id;
				$inventory->branch_id = $this->header->branch_id;
				$inventory->unit_id = $detail->unit_id;
				$inventory->date = $this->header->date;
				$inventory->quantity_in = $detail->quantity_adjustment - $detail->quantity_current;
				$inventory->warehouse_id = $this->header->warehouse_id;
				
				$valid = $inventory->save(false) && $valid;
			}
		}
		return $valid;
	}

	public function addDetail($id)
	{
		$product = Product::model()->findByPk($id);

		if ($product !== null)
		{
			$exist = false;
			foreach ($this->details as $i => $detail)
			{
				if ($product->id === $detail->product_id)
				{
					$exist = true;
					break;
				}
			}
			if ($exist)
				$this->details[$i]->quantity_adjustment++;
			else
			{
				$detail = new AdjustmentDetail();
				$detail->product_id = $product->id;
				$detail->unit_id = $product->unit_id_single;
				$this->details[] = $detail;
			}
		}
	}
}
