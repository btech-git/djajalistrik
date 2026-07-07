<?php

class ReceiptTemporary extends CComponent
{
	public $header;
	public $details;

	public function __construct($header, array $details )
	{
		$this->header = $header;
		$this->details = $details;
	}

	public function addDetail($id)
	{
		$invoiceTemporary = InvoiceTemporary::model()->findByPk($id);

		if ($invoiceTemporary !== null)
		{
			$exist = false;
			foreach ($this->details as $i => $detail)
			{
				if ($invoiceTemporary->id === $detail->invoice_temporary_id)
				{
					$exist = true;
					break;
				}
			}
			
			if ($invoiceTemporary->customer_id !== $this->header->customer_id)
				$exist = true;

			if (!$exist)
			{
				$detail = new ReceiptTemporaryDetail();
				$detail->invoice_temporary_id = $invoiceTemporary->id;
				$this->details[] = $detail;
			}
		}
	}

	public function removeDetailAt($index)
	{
		array_splice($this->details, $index, 1);
	}
	
	public function resetDetail()
	{
		$this->details = array();
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
			if ($detail->isNewRecord)
				$detail->receipt_temporary_header_id = $this->header->id;
			
			$valid = $detail->save(false) && $valid;
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
				$fields = array('receipt_temporary_header_id, invoice_temporary_id');
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
				
				if ($this->details[$i]->invoice_temporary_id === $this->details[$j]->invoice_temporary_id)
				{
					$valid = false;
					$this->header->addError('error', 'Invoice tidak boleh sama.');
					break;
				}
			}
		}

		return $valid;
	}
	
	public function getTotalInvoice()
	{
		$total = 0.00;
		
		foreach ($this->details as $detail)
		{
			$total += ($detail->invoiceTemporary === null) ? 0.00 : $detail->invoiceTemporary->amount;
		}
		
		return $total;
	}
}
