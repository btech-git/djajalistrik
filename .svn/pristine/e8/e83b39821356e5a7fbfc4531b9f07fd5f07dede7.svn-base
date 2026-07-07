<?php

class StockLocalController extends Controller
{
	public function filters()
	{
		return array(
			'access',
		);
	}

	public function filterAccess($filterChain)
	{
		if ($filterChain->action->id === 'report')
		{
			if (!(Yii::app()->user->checkAccess('adjustmentReport') || Yii::app()->user->checkAccess('transferReport')))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}
	
	public function actionReport()
	{
		$product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());

		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

		$stockLocalReport = new StockLocalReport($product->search());
		$stockLocalReport->setupLoading();
		$stockLocalReport->setupPaging($pageSize, $currentPage);
		$stockLocalReport->setupSorting();

		$branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : 1;
		
		$this->render('report', array(
			'stockLocalReport' => $stockLocalReport,
			'product' => $product,
			'currentSort' => $currentSort,
			'branchId' => $branchId,
		));
	}
}
?>