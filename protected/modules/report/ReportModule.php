<?php

class ReportModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'report.models.*',
			'report.components.*',
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
