<?php

class SaleCustomerController extends Controller
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
		$customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
		
		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

		$saleCustomerReport = new SaleCustomerReport($customer->search());
		$saleCustomerReport->setupLoading();
		$saleCustomerReport->setupPaging($pageSize, $currentPage);
		$saleCustomerReport->setupSorting();
		$saleCustomerReport->setupFilter($startDate, $endDate);

		$this->render('report', array(
			'saleCustomerReport' => $saleCustomerReport,
			'customer' => $customer,
			'currentSort' => $currentSort,
			'startDate' => $startDate,
			'endDate' => $endDate,
		));
	}
}
