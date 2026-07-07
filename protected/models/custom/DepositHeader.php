<?php

class DepositHeader extends DepositHeaderBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
		public function getTotal()
	{
		$total = 0.00;

		foreach ($this->depositDetails as $detail)
			$total += $detail->amount;

		return $total;
	}
}