<?php

class PurchaseItemController extends Controller
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
			if (!(Yii::app()->user->checkAccess('invoiceReport')))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}
	
	public function actionReport()
	{
		$product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());

		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

		$purchaseItemReport = new PurchaseItemReport($product->search());
		$purchaseItemReport->setupLoading();
		$purchaseItemReport->setupPaging($pageSize, $currentPage);
		$purchaseItemReport->setupSorting();
		$purchaseItemReport->setupFilter($startDate, $endDate);

		$this->render('report', array(
			'purchaseItemReport' => $purchaseItemReport,
			'product' => $product,
			'currentSort' => $currentSort,
			'startDate' => $startDate,
			'endDate' => $endDate,
		));
	}
}
