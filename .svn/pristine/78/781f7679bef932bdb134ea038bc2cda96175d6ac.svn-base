<?php

class ProductCategoryMainController extends CrudController
{
	public $layout = '//layouts/column2';

	public function filters()
	{
		return array(
			'access',
		);
	}

	public function filterAccess($filterChain)
	{
		if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'create' || $filterChain->action->id === 'update'|| $filterChain->action->id === 'view')
		{
			if (!Yii::app()->user->checkAccess('administrator'))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}

	public function actionView($id)
	{
		$this->render('view', array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model = new ProductCategoryMain;

		if (isset($_POST['ProductCategoryMain']))
		{
			$model->attributes = $_POST['ProductCategoryMain'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('create', array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if (isset($_POST['ProductCategoryMain']))
		{
			$model->attributes = $_POST['ProductCategoryMain'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}
	
	public function actionAdmin()
	{
		$model = new ProductCategoryMain('search');
		$model->unsetAttributes();
		if (isset($_GET['ProductCategoryMain']))
			$model->attributes = $_GET['ProductCategoryMain'];

		$this->render('admin', array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = ProductCategoryMain::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}
