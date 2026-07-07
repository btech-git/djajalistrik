<?php

class TransactionModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'transaction.models.*',
			'transaction.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
			return true;
		else
			return false;
	}
}
