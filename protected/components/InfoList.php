<?php

class InfoList extends CComponent
{
	public static function getString($tableName, $valueColumn, $values, $infoColumn, $separator = ', ')
	{
		if (empty($values))
			return '';
		
		$sql = "SELECT {$infoColumn} FROM {$tableName} WHERE {$valueColumn} IN ({$values})";

		$rows = Yii::app()->db->createCommand($sql)->queryAll(true);
		
		$list = array();
		foreach ($rows as $row)
		{
			$list[] = $row[$infoColumn];
		}
		
		return implode($separator, $list);
	}
	
}
