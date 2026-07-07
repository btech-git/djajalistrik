<?php

class Expense extends CComponent
{
	public $header;
	public $details;

	public function __construct($header, array $details)
	{
		$this->header = $header;
		$this->details = $details;
	}

	public function addDetail()
	{
		$detail = new ExpenseDetail();

		$this->details[] = $detail;
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
			if ($detail->amount <= 0) continue;
			
			if ($detail->isNewRecord)
				$detail->expense_header_id = $this->header->id;
			
			$valid = $detail->save(false) && $valid;
		}

		return $valid;
	}
	
	public function validate()
	{
		$valid = $this->header->validate();

		if (count($this->details) > 0)
		{
			foreach ($this->details as $detail)
			{
				$fields = array('amount', 'memo');
				$valid = $detail->validate($fields) && $valid;
			}
		}
		else
			$valid = false;
		
		return $valid;
	}
	
	public function getTotal()
	{
		$total = 0.00;
		foreach ($this->details as $detail)
			$total += $detail->amount;

		return $total;
	}
}

