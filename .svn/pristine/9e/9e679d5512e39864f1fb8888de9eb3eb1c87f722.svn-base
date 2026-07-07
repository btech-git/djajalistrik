<?php

class ReceiptTemporaryController extends Controller
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
			if (!(Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit')))
				$this->redirect(array('/site/login'));
		}
		if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxJsoncustomer' || $filterChain->action->id === 'ajaxHtmlAddPurchase' || $filterChain->action->id === 'ajaxHtmlResetDetail' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo')
		{
			if (!(Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit')))
				$this->redirect(array('/site/login'));
		}
		if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update')
		{
			if (!(Yii::app()->user->checkAccess('saleReceiptEdit')))
				$this->redirect(array('/site/login'));
		}
		if ($filterChain->action->id === 'report')
		{
			if (!(Yii::app()->user->checkAccess('saleReceiptReport')))
				$this->redirect(array('/site/login'));
		}

		$filterChain->run();
	}
	
	public function actionCreate()
	{
		$receiptTemporary = $this->instantiate(null);
		$receiptTemporary->header->number = CodeNumber::make($receiptTemporary->header, 'number', 'SRT', Yii::app()->user);
		$receiptTemporary->header->admin_id = Yii::app()->user->id;
		$receiptTemporary->header->branch_id = Yii::app()->user->branch_id;

		$customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        
		$invoiceTemporary = Search::bind(new InvoiceTemporary('search'), isset($_GET['InvoiceTemporary']) ? $_GET['InvoiceTemporary'] : array());
		$dataProvider = $invoiceTemporary->searchByReceiptTemporary();
		$dataProvider->criteria->with = array(
			'paymentType:resetScope',
			'customer:resetScope',
		);
		
		$error = false;
		if (isset($_POST['Submit']))
		{
			$this->loadState($receiptTemporary);
			if ($receiptTemporary->save(Yii::app()->db))
			{
				Yii::app()->session['ReceiptTemporaryMemoAllowed'] = true;
				$this->redirect(array('view', 'id' => $receiptTemporary->header->id));
			}
			else
				$error = true;
		}
		
		if (isset($_POST['Cancel']))
		{
			$this->redirect(array('admin'));
		}
		
		$this->render('create', array(
			'receiptTemporary' => $receiptTemporary,
			'invoiceTemporary' => $invoiceTemporary,
			'customer' => $customer,
			'dataProvider' => $dataProvider,
			'error' => $error,
		));
	}
	
	public function actionUpdate($id)
	{
		$receiptTemporary = $this->instantiate($id);

		$receiptTemporary->header->admin_id = Yii::app()->user->id;
		$receiptTemporary->header->branch_id = Yii::app()->user->branch_id;
		
		$customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
//        $purchase = Search::bind(new PurchaseHeader('search'), isset($_GET['PurchaseHeader']) ? $_GET['PurchaseHeader'] : array());
//		$dataProvider = $purchase->searchByPurchaseReceipt();
//		$dataProvider->criteria->with = array(
//			'orderHeader:resetScope',
//			'customer:resetScope',
//		);
		
		$error = false;
		
		if (isset($_POST['Submit']))
		{
			$this->loadState($receiptTemporary);
			if ($receiptTemporary->save(Yii::app()->db))
				$this->redirect(array('view', 'id' => $receiptTemporary->header->id));
			else
				$error = true;
		}
		
		if (isset($_POST['Cancel']))
		{
			$this->redirect(array('admin'));
		}
		
		$this->render('update', array(
			'receiptTemporary' => $receiptTemporary,
			'invoiceTemporary' => $invoiceTemporary,
			'customer' => $customer,
			'dataProvider' => $dataProvider,
			'error' => $error,
		));
	}

	public function actionView($id)
	{
		$receiptTemporary = $this->loadModel($id);
		
		$customer = $receiptTemporary->customer(array('scopes' => 'resetScope'));
		$branch = $receiptTemporary->branch(array('scopes' => 'resetScope'));
		
		$criteria = new CDbCriteria;
		$criteria->compare('receipt_temporary_header_id', $receiptTemporary->id);
		$detailsDataProvider = new CActiveDataProvider('ReceiptTemporaryDetail', array(
			'criteria'=>$criteria,
		));
		
		$detailsDataProvider->criteria->with = array(
			'invoiceTemporary:resetScope'=>array(
				'with'=>array('customer:resetScope', 'paymentType:resetScope'),
			),
		);

		$this->render('view', array(
			'receiptTemporary' => $receiptTemporary,
			'customer' => $customer,
			'branch' => $branch,
			'detailsDataProvider' => $detailsDataProvider,
		));
	}

	public function actionMemo($id)
	{
		if (!(Yii::app()->user->checkAccess('administrator')))
        {
            if (!(isset(Yii::app()->session['ReceiptTemporaryMemoAllowed']) && Yii::app()->session['ReceiptTemporaryMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('ReceiptTemporaryMemoAllowed');
		
		$receiptTemporary = $this->loadModel($id);
		
		$customer = $receiptTemporary->customer(array('scopes' => 'resetScope'));
		$branch = $receiptTemporary->branch(array('scopes' => 'resetScope'));
		
		$receiptTemporaryDetails = $receiptTemporary->receiptTemporaryDetails(array(
			'with' => array(
				'invoiceTemporary:resetScope' => array(
					'with' => 
						'customer:resetScope',
						'paymentType:resetScope',
				),
			),
		));

		$this->render('memo', array(
			'receiptTemporary' => $receiptTemporary,
			'customer' => $customer,
			'branch' => $branch,
			'receiptTemporaryDetails' => $receiptTemporaryDetails,
		));
	}

//	public function actionReport()
//	{
//		$receiptTemporaryHeader = Search::bind(new ReceiptTemporaryHeader('search'), isset($_GET['ReceiptTemporaryHeader']) ? $_GET['ReceiptTemporaryHeader'] : array());
//
//		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
//		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
//		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
//		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
//		$currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
//
//		$receiptTemporaryReport = new PurchaseReceiptReport($receiptTemporaryHeader->search());
//		$receiptTemporaryReport->setupLoading();
//		$receiptTemporaryReport->setupPaging($pageSize, $currentPage);
//		$receiptTemporaryReport->setupSorting();
//		$receiptTemporaryReport->setupFilter($startDate, $endDate);
//
//		$this->render('report', array(
//			'purchaseReceiptReport' => $receiptTemporaryReport,
//			'ReceiptTemporaryHeader' => $receiptTemporaryHeader,
//			'startDate' => $startDate,
//			'endDate' => $endDate,
//			'currentSort' => $currentSort,
//		));
//	}

	public function actionAdmin()
	{
		$receiptTemporary = Search::bind(new ReceiptTemporaryHeader('search'), isset($_GET['ReceiptTemporaryHeader']) ? $_GET['ReceiptTemporaryHeader'] : array());

		$dataProvider = $receiptTemporary->search();
		$dataProvider->criteria->with = array(
			'customer:resetScope',
			'branch:resetScope',
		);

		$buttonTemplate = '{view}';
		if (Yii::app()->user->checkAccess('saleReceiptEdit'))
			$buttonTemplate .= '{update}';
		if (Yii::app()->user->checkAccess('administrator'))
			$buttonTemplate .= '{delete}';
		
		$this->render('admin', array(
			'receiptTemporary' => $receiptTemporary,
			'dataProvider' => $dataProvider,
			'buttonTemplate' => $buttonTemplate,
		));
	}
	
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$receiptTemporaryHeader = $this->loadModel($id);
			if ($receiptTemporaryHeader !== null)
			{
				$receiptTemporaryHeader->is_inactive = !$receiptTemporaryHeader->is_inactive;
				$receiptTemporaryHeader->update(array('is_inactive'));
			}

			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionAjaxJsonCustomer($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$customerId = (isset($_POST['ReceiptTemporaryHeader']['customer_id'])) ? $_POST['ReceiptTemporaryHeader']['customer_id'] : '';

			$customer = Customer::model()->findByPk($customerId);
			
			$object = array(
				'customer_id' => CHtml::value($customer,'id'),
				'customer_name' => CHtml::value($customer,'name'),
				'customer_company' => CHtml::value($customer,'company'),
				'customer_address' => CHtml::value($customer,'address_1'),
				'customer_city' => CHtml::value($customer,'city'),
				'customer_phone' => CHtml::value($customer,'company_phone_1'),
			);
			echo CJSON::encode($object);
		}
	}

	public function actionAjaxHtmlAddInvoiceTemporary($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$receiptTemporary = $this->instantiate($id);

			$this->loadState($receiptTemporary);

			if (isset($_POST['InvoiceTemporaryId']))
				$receiptTemporary->addDetail($_POST['InvoiceTemporaryId']);

			$this->renderPartial('_detail', array(
				'receiptTemporary' => $receiptTemporary,
				'error' => false,
			));
		}
	}

	public function actionAjaxHtmlResetDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$receiptTemporary = $this->instantiate($id);

			$this->loadState($receiptTemporary);

			if (isset($_POST['ReceiptTemporaryHeader']['customer_id']))
				$receiptTemporary->resetDetail();

			$this->renderPartial('_detail', array(
				'receiptTemporary' => $receiptTemporary,
				'error' => false,
			));
		}
	}

	public function actionAjaxHtmlRemoveDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$receiptTemporary = $this->instantiate($id);

			$this->loadState($receiptTemporary);

			$receiptTemporary->removeDetailAt($index);

			$this->renderPartial('_detail', array(
				'receiptTemporary' => $receiptTemporary,
				'error' => false,
			));
		}
	}
	
	public function instantiate($id)
    {
        if (empty($id))
            $receiptTemporary = new ReceiptTemporary(new ReceiptTemporaryHeader(), array());
        else
        {
            $receiptTemporaryHeader = $this->loadModel($id);
            $receiptTemporary = new ReceiptTemporary($receiptTemporaryHeader, $receiptTemporaryHeader->receiptTemporaryDetails);
        }

        return $receiptTemporary;
    }

    public function loadModel($id)
    {
        $model = ReceiptTemporaryHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

	public function loadState($receiptTemporary)
	{
		if (isset($_POST['ReceiptTemporaryHeader']))
        {
            $receiptTemporary->header->attributes = $_POST['ReceiptTemporaryHeader'];
        }
        if (isset($_POST['ReceiptTemporaryDetail']))
        {
            foreach ($_POST['ReceiptTemporaryDetail'] as $i => $item)
            {
                if (isset($receiptTemporary->details[$i]))
                    $receiptTemporary->details[$i]->attributes = $item;
                else
                {
                    $detail = new ReceiptTemporaryDetail();
                    $detail->attributes = $item;
                    $receiptTemporary->details[] = $detail;
                }
            }
            if (count($_POST['ReceiptTemporaryDetail']) < count($receiptTemporary->details))
                array_splice($receiptTemporary->details, $i + 1);
        }
        else
            $receiptTemporary->details = array();
	}
}
?>