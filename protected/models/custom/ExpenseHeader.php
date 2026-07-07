<?php

class ExpenseHeader extends ExpenseHeaderBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotal()
	{
		$total = 0.00;

		foreach ($this->expenseDetails as $detail)
			$total += $detail->amount;

		return $total;
	}
}