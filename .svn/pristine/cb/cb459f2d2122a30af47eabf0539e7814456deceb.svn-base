<?php

class CodeNumber
{
	public static function make($models, $attribute, $constant)
	{
		$record = self::makeFromOne($models, $attribute);

//		$branch = Branch::model()->findByPk($branchId);
//        $branchCode = $branch->code;
		$dayNow = date('d');
		$monthNow = date('m');
		$yearNow = date('y');

		if ($record === false)
			$ordinal = 0;
		else
		{
			list(, $year, $month, $day, $ordinal) = explode('/', $record[$attribute]) + array($constant, $yearNow, $monthNow, $dayNow, 0);

			$valid = $year < $yearNow;

			if ($valid)
				$ordinal = 0;
		}

		$codeNumber = sprintf('%s/%02d/%s/%02d/%04d', $constant, $yearNow, $monthNow, $dayNow, $ordinal + 1);

		return $codeNumber;
	}

	private static function makeFromOne($model, $attribute)
	{
		$record = CActiveRecord::$db->createCommand()
			->select("{$attribute}, SUBSTRING_INDEX({$attribute}, '/', -1) AS ordinal, SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -2), '/', 1) AS day, CASE SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -3), '/', 1) WHEN 'IX' THEN 'VIIII' ELSE SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -3), '/', 1) END AS month, SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -4), '/', 1) AS year, SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -5), '/', 1) AS branch")
			->from($model->tableName())
			->order('year DESC, ordinal DESC')
			->queryRow();

		return $record;
	}
	
//	public static function make($models, $attribute, $constant)
//	{
//		$record = self::makeFromOne($models, $attribute);
//
//		$months = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
//
//		$dayNow = date('d');
//		$monthNow = date('m');
//		$yearNow = date('y');
//
//		if ($record === false)
//			$ordinal = 0;
//		else
//		{
//			list(, $year, $month, $day, $ordinal) = explode('/', $record[$attribute]) + array($constant, $yearNow, $monthNow, $dayNow, 0);
//
//			$valid = $year < $yearNow || ($month < $months[$monthNow - 1]) || $day < $dayNow;
//
//			if ($valid)
//				$ordinal = 0;
//		}
//
//		$codeNumber = sprintf('%s/%03d/%s/%02d/%04d', $constant, $yearNow, $months[$monthNow - 1], $dayNow, $ordinal + 1);
//
//		return $codeNumber;
//	}
//
//	private static function makeFromOne($model, $attribute)
//	{
//		$record = CActiveRecord::$db->createCommand()
//			->select("{$attribute}, SUBSTRING_INDEX({$attribute}, '/', -1) AS ordinal, SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -2), '/', 1) AS day, CASE SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -3), '/', 1) WHEN 'IX' THEN 'VIIII' ELSE SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -3), '/', 1) END AS month, SUBSTRING_INDEX(SUBSTRING_INDEX({$attribute}, '/', -4), '/', 1) AS year")
//			->from($model->tableName())
//			->order('year DESC, month DESC, day DESC, ordinal DESC')
//			->queryRow();
//
//		return $record;
//	}
	
	public static function makeTaxform($invoiceId, $branchId, $adminId)
	{
		$taxform = new Taxform();
		$taxform->invoice_id = $invoiceId;
		$taxform->branch_id = $branchId;
		$taxform->admin_id = $adminId;
		
		$taxformOld = Taxform::model()->findByAttributes(array('cn_constant' => $taxform->branch->cn_constant), array('order' => 'id DESC'));
		
		if ($taxformOld === null)
			$ordinal = $taxform->branch->cn_ordinal_start;
		else
		{
			$ordinal = $taxformOld->cn_ordinal + 1;
			if ((int)$taxformOld->cn_ordinal === -1 || $ordinal > $taxform->branch->cn_ordinal_end)
				$ordinal = -1;
		}
		
		$taxform->cn_ordinal = $ordinal;
		$taxform->cn_constant = $taxform->branch->cn_constant;
		
		return $taxform;
	}
}
