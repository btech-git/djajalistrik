<?php
class QuotationController extends Controller
{
	public function filters()
	{
		return array(
			'access',
		);
	}
	
	public function filterAccess($filterChain)
	{
		if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view')
		{
			if (!(Yii::app()->user->checkAccess('quotationCreate') || Yii::app()->user->checkAccess('quotationEdit')))
				$this->redirect(array('/site/login'));
		}
		if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxJsonCustomer' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'updateAllDiscount'|| $filterChain->action->id === 'memo')
		{
			if (!(Yii::app()->user->checkAccess('quotationCreate')))
				$this->redirect(array('/site/login'));
		}
		if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update')
		{
			if (!(Yii::app()->user->checkAccess('quotationEdit')))
				$this->redirect(array('/site/login'));
		}
		if ($filterChain->action->id === 'report')
		{
			if (!(Yii::app()->user->checkAccess('quotationReport')))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}
	
	public function actionReport()
	{
		$quotationHeader = Search::bind(new QuotationHeader('search'), isset($_GET['QuotationHeader']) ? $_GET['QuotationHeader'] : array());

		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

		$quotationReport = new QuotationReport($quotationHeader->search());
		$quotationReport->setupLoading();
		$quotationReport->setupPaging($pageSize, $currentPage);
		$quotationReport->setupSorting();
		$quotationReport->setupFilter($startDate, $endDate);

		$this->render('report', array(
			'quotationReport' => $quotationReport,
			'quotationHeader' => $quotationHeader,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'currentSort' => $currentSort,
		));
	}
	
}
?>