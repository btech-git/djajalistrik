<?php

class AgingScheduleController extends Controller
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
			if (!(Yii::app()->user->checkAccess('salePaymentReport')))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}
	
	public function actionReport()
	{
		$invoice = Search::bind(new Invoice('search'), isset($_GET['Invoice']) ? $_GET['Invoice'] : array());

		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
		$customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';

		$agingScheduleReport = new AgingScheduleReport($invoice->search());
		$agingScheduleReport->setupLoading($startDate, $endDate);
		$agingScheduleReport->setupPaging($pageSize, $currentPage);
		$agingScheduleReport->setupSorting();
		$agingScheduleReport->setupFilter($startDate, $endDate);

		$this->render('report', array(
			'invoice' => $invoice,
			'agingScheduleReport' => $agingScheduleReport,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'currentSort' => $currentSort,
			'customerId' => $customerId,
		));
	}
}
