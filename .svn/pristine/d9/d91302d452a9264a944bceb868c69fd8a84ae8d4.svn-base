<?php

class PurchaseNewItemController extends Controller
{
	public function actionSummary()
	{
		$purchaseNewProduct = Search::bind(new PurchaseNewProduct('search'), isset($_GET['PurchaseNewProduct']) ? $_GET['PurchaseNewProduct'] : array());
		
		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
		$productName = (isset($_GET['PurchaseNewProduct']['product_name'])) ? $_GET['PurchaseNewProduct']['product_name'] : '';

		$purchaseNewItemSummary = new PurchaseNewItemSummary($purchaseNewProduct->search());
		$purchaseNewItemSummary->setupLoading();
		$purchaseNewItemSummary->setupPaging($pageSize, $currentPage);
		$purchaseNewItemSummary->setupSorting();
		$purchaseNewItemSummary->setupFilter($startDate, $endDate);
		
		$this->render('summary', array(
			'purchaseNewProduct' => $purchaseNewProduct,
			'purchaseNewItemSummary' => $purchaseNewItemSummary,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'currentSort' => $currentSort,
			
		));
	}
}
