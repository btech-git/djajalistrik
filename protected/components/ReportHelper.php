<?php

class ReportHelper extends CComponent
{
	public static function summaryText($dataProvider)
	{
		$start = $dataProvider->pagination->getCurrentPage(false) * $dataProvider->pagination->pageSize + 1;
		$end = $dataProvider->pagination->getCurrentPage(false) * $dataProvider->pagination->pageSize + $dataProvider->getItemCount(false);
		$total = $dataProvider->getTotalItemCount(false);

		$text = ($total > 0) ? "Displaying {$start}-{$end} of {$total} result(s)." : '';

		return $text;
	}

	public static function sortText($sort, $labels = array())
	{
		$text = 'Sort by: ';
		foreach ($sort->attributes as $i=>$attribute)
		{
			$label = isset($labels[$i]) ? $labels[$i] : null;
			$text .= $sort->link($attribute, $label) . ' ';
		}

		return $text;
	}
}
