<?php

class BankBookController extends Controller
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
			if (!(Yii::app()->user->checkAccess('expenseReport') || Yii::app()->user->checkAccess('depositReport')))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}
	
	public function actionReport()
	{
		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
		$accountId = (isset($_GET['AccountId'])) ? $_GET['AccountId'] : 1;
		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
		$currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;

		$sql = SqlGenerator::bankBook();
		$params = array(':account_id' => $accountId, ':start_date' => $startDate, ':end_date' => $endDate);

		$dataProvider = new CSqlDataProvider($sql, array(
				'db' => CActiveRecord::$db,
				'params' => $params,
				'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($sql))->queryScalar($params),
				'pagination' => array(
					'pageVar' => 'CurrentPage',
					'pageSize' => ($pageSize > 0) ? $pageSize : 1,
					'currentPage' => $currentPage,
				),
			));

		$this->render('report', array(
			'dataProvider' => $dataProvider,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'accountId' => $accountId,
		));
	}
}
