<?php

class ProductDiscountCategoryController extends CrudController
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
		$productDiscountCategories = array();
		
		$discountCategories = DiscountCategory::model()->findAll();
		foreach ($discountCategories as $discountCategory)
		{
			$model = new ProductDiscountCategory;
			$model->discount_category_id = $discountCategory->id;
			$productDiscountCategories[] = $model;
		}

		if (isset($_POST['ProductDiscountCategory'], $_POST['ProductCategoryId']))
		{
			foreach ($_POST['ProductDiscountCategory'] as $i => $item)
			{
				$productDiscountCategories[$i]->attributes = $item;
				$productDiscountCategories[$i]->product_category_id = $_POST['ProductCategoryId'];
			}
			
			if ($this->saveModels($productDiscountCategories))
				$this->redirect(array('admin'));
		}

		$this->render('create', array(
			'productDiscountCategories'=>$productDiscountCategories,
		));
	}
	
	public function saveModels($items)
	{
		$dbTransaction = Yii::app()->db->beginTransaction();
		try
		{
			$attributes = array('product_category_id' => $items[0]->product_category_id);
			$foundCount = intval(ProductDiscountCategory::model()->countByAttributes($attributes));
			$deletedCount = ProductDiscountCategory::model()->deleteAllByAttributes($attributes);
			
			$valid = ($foundCount === $deletedCount);
			foreach ($items as $item)
			{
				$valid = $item->validate() && $valid;
			}
			foreach ($items as $item)
			{
				$valid = $item->save(false) && $valid;
			}
			
			if ($valid)
				$dbTransaction->commit();
			else
				$dbTransaction->rollback();
		}
		catch (Exception $e)
		{
			$dbTransaction->rollback();
			$valid = false;
		}
		
		return $valid;
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if (isset($_POST['ProductDiscountCategory']))
		{
			$model->attributes = $_POST['ProductDiscountCategory'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

	public function actionAdmin()
	{
		$model = new ProductDiscountCategory('search');
		$model->unsetAttributes();
		if (isset($_GET['ProductDiscountCategory']))
			$model->attributes = $_GET['ProductDiscountCategory'];
		
		$dataProvider = $model->search();
		$dataProvider->model->resetScope();

		$this->render('admin', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model = ProductDiscountCategory::model()->findByPk($id, array('scopes' => 'resetScope'));
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}
