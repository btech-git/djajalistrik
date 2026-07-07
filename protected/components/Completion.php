<?php

class Completion
{
	public static function supplier($term)
	{
		$items = Supplier::model()->findAll(array('condition'=>'name LIKE :name OR company LIKE :company', 'params'=>array(':name'=>'%'.$term.'%', ':company'=>'%'.$term.'%'), 'limit'=>10));

		$rows = array();
		foreach ($items as $item)
		{
			$rows[] = array(
				'label'=>$item->name.' - '.$item->company, //label for dropdown list
				'value'=>$item->id, //value for input field
				'id'=>$item->name, //return value from autocomplete
			);
		}

		return $rows;
	}
	
	public static function customer($term)
	{
		$items = Customer::model()->findAll(array('condition'=>'name LIKE :name OR company LIKE :company', 'params'=>array(':name'=>'%'.$term.'%', ':company'=>'%'.$term.'%'), 'limit'=>10));

		$rows = array();
		foreach ($items as $item)
		{
			$rows[] = array(
				'label'=>$item->name.' - '.$item->company, //label for dropdown list
				'value'=>$item->id, //value for input field
				'id'=>$item->name, //return value from autocomplete
			);
		}

		return $rows;
	}
	
}
