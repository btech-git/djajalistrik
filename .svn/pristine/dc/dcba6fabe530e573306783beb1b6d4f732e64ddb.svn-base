<?php

class ProductClassificationController extends CrudController
{
	public $layout = '//layouts/column2';

	public function filters()
	{
		return array(
//			'accessControl',
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
		$model = new ProductClassification;

		if (isset($_POST['ProductClassification']))
		{
			$model->attributes = $_POST['ProductClassification'];
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

		if (isset($_POST['ProductClassification']))
		{
			$model->attributes = $_POST['ProductClassification'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ProductClassification');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model = new ProductClassification('search');
		$model->unsetAttributes();
		if (isset($_GET['ProductClassification']))
			$model->attributes = $_GET['ProductClassification'];

		$this->render('admin', array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = ProductClassification::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}
