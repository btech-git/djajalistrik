<?php

class ProductUnitController extends CrudController
{
	public $layout = '//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl',
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
		$model = new ProductUnit;
		
		$product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
		$dataProvider = $product->search();
		$dataProvider->criteria->with = array(
			'brand:resetScope',
		);

		if (isset($_POST['ProductUnit']))
		{
			$model->attributes = $_POST['ProductUnit'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('create', array(
			'model'=>$model,
			'dataProvider' => $dataProvider,
			'product' => $product,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		$product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
		$dataProvider = $product->search();
		$dataProvider->criteria->with = array(
			'brand:resetScope',
		);

		if (isset($_POST['ProductUnit']))
		{
			$model->attributes = $_POST['ProductUnit'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('update', array(
			'model'=>$model,
			'dataProvider' => $dataProvider,
			'product' => $product,
		));
	}

	public function actionAdmin()
	{
		$model = new ProductUnit('search');
		$model->unsetAttributes();
		if (isset($_GET['ProductUnit']))
			$model->attributes = $_GET['ProductUnit'];
		
		$dataProvider = $model->search();
		$dataProvider->model->resetScope();

		$this->render('admin', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAjaxJsonProduct($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$productId = (isset($_POST['ProductUnit']['product_id'])) ? $_POST['ProductUnit']['product_id'] : '';

			$product = Product::model()->findByPk($productId, array('scopes' => 'resetScope', 'with' => 'brand:resetScope'));

			$object = array(
				'product_code' =>  CHtml::value($product,'code'),
				'product_name' =>CHtml::value($product,'name'),
				'product_type' =>  CHtml::value($product,'type'),
				'product_size' => CHtml::value($product,'size'),
			);
			echo CJSON::encode($object);
		}
	}

	public function loadModel($id)
	{
		$model = ProductUnit::model()->findByPk($id, array('scopes' => 'resetScope'));
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}
