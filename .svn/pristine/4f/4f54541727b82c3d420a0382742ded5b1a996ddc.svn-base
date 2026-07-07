<?php

class Quotation extends CComponent
{
	public $header;
	public $details;

	public function __construct($header, array $details)
	{
		$this->header = $header;
		$this->details = $details;
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

			$detail = new QuotationDetail();
			$detail->product_id = $product->id;
			$detail->product_name = $product->name;
			$detail->unit_id = $product->unit_id_single;
			$detail->unit_price = $product->selling_price;
			$this->details[] = $detail;

			$keys = array_keys($this->details);
			$this->updateDiscountAt(end($keys));
		}
	}

	public function updateDiscount()
	{
		foreach ($this->details as $i => $detail)
		{
			$this->updateDiscountAt($i);
		}
	}

	public function updateDiscountAt($index)
	{
		if ($this->details[$index]->product === null || empty($this->header->customer->discount_category_id))
		{
			$this->details[$index]->discount_1 = '0.00';
			$this->details[$index]->discount_2 = '0.00';
			$this->details[$index]->discount_3 = '0.00';
			$this->details[$index]->discount_4 = '0.00';
			$this->details[$index]->discount_5 = '0.00';
			$this->details[$index]->quotation_value = '0.00';
		}
		else
		{
			if ($this->details[$index]->unit_id === $this->details[$index]->product->unit_id_single)
				$productCategoryId = $this->details[$index]->product->product_category_id_single;
			else if ($this->details[$index]->unit_id === $this->details[$index]->product->unit_id_bulk)
				$productCategoryId = $this->details[$index]->product->product_category_id_bulk;
			else
				$productCategoryId = null;

			$productDiscountCategory = ProductDiscountCategory::model()->findByAttributes(array(
				'product_category_id' => $productCategoryId,
				'discount_category_id' => $this->header->customer->discount_category_id,
				));

			if ($productDiscountCategory !== null)
			{
				$this->details[$index]->discount_1 = $productDiscountCategory->value_1;
				$this->details[$index]->discount_2 = $productDiscountCategory->value_2;
				$this->details[$index]->discount_3 = $productDiscountCategory->value_3;
				$this->details[$index]->discount_4 = $productDiscountCategory->value_4;
				$this->details[$index]->discount_5 = $productDiscountCategory->value_5;
				$this->details[$index]->quotation_value = $productDiscountCategory->quotation_value;
			}
		}
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

	public function flush()
	{
		$valid = $this->header->save(false);
		foreach ($this->details as $detail)
		{
			if ($detail->quantity <= 0)
				continue;

			if ($detail->isNewRecord)
				$detail->quotation_header_id = $this->header->id;

			$valid = $detail->save(false) && $valid;
		}

		return $valid;
	}

	public function validate()
	{
		$valid = $this->header->validate();

		$valid = $this->validateDetailsCount() && $valid;
//		$valid = $this->validateDetailsUnique() && $valid;
		
		if (count($this->details) > 0)
		{
			foreach ($this->details as $detail)
			{
				$fields = array('quantity', 'unit_price');
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
	
	public function getSubTotal()
	{
		$total = 0.00;

		foreach ($this->details as $detail)
		{
			if ((int) $detail->is_inactive === ActiveRecord::ACTIVE)
				$total += $detail->total;
		}

		return $total;
	}

	public function getGrandTotal()
	{
		return $this->subTotal;
	}
}