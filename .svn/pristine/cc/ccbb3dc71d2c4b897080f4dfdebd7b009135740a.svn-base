<?php

class SalePaymentController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'ajaxJsonSaleReceipt' || $filterChain->action->id === 'ajaxHtmlSummary' || $filterChain->action->id === 'ajaxHtmlAddPayment' || $filterChain->action->id === 'ajaxHtmlRemovePayment' || $filterChain->action->id === 'ajaxHtmlResetPayment' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('salePaymentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCustomerList() {

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->addCondition('t.is_inactive = 0');
        $customerDataProvider->criteria->order = 't.name ASC';
        $customerDataProvider->pagination->pageSize = 50;

        $this->render('customerList', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionCreate($customerId) {
        $salePayment = $this->instantiate(null);
        $customer = Customer::model()->findByPk($customerId);
        $salePayment->header->number = CodeNumber::make($salePayment->header, 'number', 'SPY', Yii::app()->user);
        $salePayment->header->admin_id = Yii::app()->user->id;
//        $salePayment->header->branch_id = Yii::app()->user->branch_id;
        $salePayment->header->customer_id = $customerId;
        $salePayment->header->invoice_header_id = null;

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $dataProvider = $invoiceHeader->searchBySalePayment();

        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition("customer_id = :customer_id");
            $dataProvider->criteria->params[':customer_id'] = $customerId;
        }

        if (isset($_POST['Submit'])) {
            $this->loadState($salePayment);

            if ($salePayment->save(Yii::app()->db)) {
                Yii::app()->session['SalePaymentMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $salePayment->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'salePayment' => $salePayment,
            'invoiceHeader' => $invoiceHeader,
            'dataProvider' => $dataProvider,
            'customer' => $customer,
        ));
    }

    public function actionUpdate($id) {
        $salePayment = $this->instantiate($id);
        $salePayment->header->admin_id = Yii::app()->user->id;

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $dataProvider = $invoiceHeader->searchBySalePayment();
        
        if (!empty($salePayment->header->customer_id)) {
            $dataProvider->criteria->addCondition("customer_id = :customer_id");
            $dataProvider->criteria->params[':customer_id'] = $salePayment->header->customer_id;
        }

        $customer = Customer::model()->findByPk($salePayment->header->customer_id);
        
        if (isset($_POST['Submit'])) {
            $this->loadState($salePayment);

            if ($salePayment->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $salePayment->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'salePayment' => $salePayment,
            'invoiceHeader' => $invoiceHeader,
            'dataProvider' => $dataProvider,
            'customer' => $customer,
        ));
    }

    public function actionView($id) {
        $salePayment = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('sale_payment_header_id', $salePayment->id);
        $detailsDataProvider = new CActiveDataProvider('SalePaymentDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'paymentType:resetScope'
        );

        $this->render('view', array(
            'salePayment' => $salePayment,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['SalePaymentMemoAllowed']) && Yii::app()->session['SalePaymentMemoAllowed'] === true)) {
                $this->redirect(array('admin'));
            }
        }

        Yii::app()->session->remove('SalePaymentMemoAllowed');

        $salePayment = $this->loadModel($id);

        $branch = $salePayment->branch(array('scopes' => 'resetScope'));
        $invoice = $salePayment->invoiceHeader(array(
            'scopes' => 'resetScope',
            'with' => array(
                'customer'
            )
        ));

        $salePaymentDetails = $salePayment->salePaymentDetails(array(
            'with' => array(
                'paymentType:resetScope'
            ),
        ));

        $this->render('memo', array(
            'salePayment' => $salePayment,
            'invoice' => $invoice,
            'branch' => $branch,
            'salePaymentDetails' => $salePaymentDetails,
        ));
    }

    public function actionAdmin() {
        $salePayment = Search::bind(new SalePaymentHeader('search'), isset($_GET['SalePaymentHeader']) ? $_GET['SalePaymentHeader'] : array());

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $salePaymentDate = (isset($_GET['SalePaymentHeaderDate'])) ? $_GET['SalePaymentHeaderDate'] : '';

        $dataProvider = $salePayment->search();

        if (!empty($salePaymentDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $salePaymentDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('salePaymentEdit')) {
            $buttonTemplate .= '{update}';
        }
        if (Yii::app()->user->checkAccess('administrator')) {
            $buttonTemplate .= '{delete}';
        }

        $this->render('admin', array(
            'salePayment' => $salePayment,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            
            $salePayment = $this->loadModel($id);
            $salePayment->is_inactive = ActiveRecord::INACTIVE;
            $salePayment->update(array('is_inactive'));

            foreach ($salePayment->salePaymentDetails as $detail) {
                $detail->is_inactive = ActiveRecord::INACTIVE;
                $detail->update(array('is_inactive'));

                $invoiceHeader = $detail->invoiceHeader; 
                $invoiceHeader->total_payment = $invoiceHeader->getTotalPayment();
                $invoiceHeader->update(array('total_payment'));
            }

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);
            $this->loadState($salePayment);

            if (isset($_POST['selectedIds'])) {
                $invoiceIds = array();
                $invoiceIds = $_POST['selectedIds'];

                foreach ($invoiceIds as $invoiceId) {
                    $salePayment->addInvoice($invoiceId);
                }
            }

            $this->renderPartial('_detail', array(
                'salePayment' => $salePayment,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);
            $this->loadState($salePayment);
            
            $salePayment->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'salePayment' => $salePayment,
            ));
        }
    }

    public function actionAjaxJsonSummary($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);
            $this->loadState($salePayment);

            $amount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment->details[$index], 'amount')));
            $additionalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment->details[$index], 'additional_amount')));
            $remaining = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'remaining')));
            $total_payment = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'totalPayment')));

            echo CJSON::encode(array(
                'amount' => $amount,
                'additional_amount' => $additionalAmount,
                'remaining' => $remaining,
                'total_payment' => $total_payment,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $salePayment = new SalePayment(new SalePaymentHeader(), array());
        } else {
            $salePayment = $this->loadModel($id);
            $salePayment = new SalePayment($salePayment, $salePayment->salePaymentDetails);
        }

        return $salePayment;
    }

    public function loadModel($id) {
        $model = SalePaymentHeader::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    public function loadState($salePayment) {
        if (isset($_POST['SalePaymentHeader'])) {
            $salePayment->header->attributes = $_POST['SalePaymentHeader'];
        }
        if (isset($_POST['SalePaymentDetail'])) {
            foreach ($_POST['SalePaymentDetail'] as $i => $item) {

                if (isset($salePayment->details[$i])) {
                    $salePayment->details[$i]->attributes = $item;
                } else {
                    $detail = new SalePaymentDetail();
                    $detail->attributes = $item;
                    $salePayment->details[] = $detail;
                }
            }
            if (count($_POST['SalePaymentDetail']) < count($salePayment->details)) {
                array_splice($salePayment->details, $i + 1);
            }
        } else {
            $salePayment->details = array();
        }
    }
}
?>