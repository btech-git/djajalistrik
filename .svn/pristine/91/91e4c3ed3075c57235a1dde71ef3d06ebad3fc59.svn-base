<?php

class SaleReceiptController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'ajaxHtmlAddInvoice' || $filterChain->action->id === 'ajaxJsonCustomer' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxHtmlResetDetail' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('saleReceiptEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('saleReceiptReport')))
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
        $saleReceipt = $this->instantiate(null);
        $customer = Customer::model()->findByPk($customerId);
        $saleReceipt->header->number = CodeNumber::make($saleReceipt->header, 'number', 'RCP', Yii::app()->user);
        $saleReceipt->header->admin_id = Yii::app()->user->id;
        $saleReceipt->header->customer_id = $customerId;
        $saleReceipt->header->date = date('Y-m-d');
        $saleReceipt->header->delivery_date = date('Y-m-d');
        $saleReceipt->header->delivery_address = $customer->address_1;
//        $saleReceipt->header->note = $saleReceipt->header->branch->invoice_note;

        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $dataProvider = $invoice->searchBySaleReceipt();
        
        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition("customer_id = :customer_id");
            $dataProvider->criteria->params[':customer_id'] = $customerId;
        }

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($saleReceipt);
            
            if ($saleReceipt->save(Yii::app()->db)) {
                Yii::app()->session['SaleReceiptMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $saleReceipt->header->id));
            } else {
                $error = true;
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'saleReceipt' => $saleReceipt,
            'invoice' => $invoice,
            'customer' => $customer,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $saleReceipt = $this->instantiate($id);

        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $dataProvider = $invoice->searchBySaleReceipt();
        $dataProvider->criteria->addCondition("customer_id = :customer_id");
        $dataProvider->criteria->params[':customer_id'] = $saleReceipt->header->customer_id;

        $customer = Customer::model()->findByPk($saleReceipt->header->customer_id);
        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($saleReceipt);
            if ($saleReceipt->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleReceipt->header->id));
            } else {
                $error = true;
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'saleReceipt' => $saleReceipt,
            'invoice' => $invoice,
            'customer' => $customer,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $saleReceipt = $this->loadModel($id);

        $customer = $saleReceipt->customer(array('scopes' => 'resetScope'));
        $branch = $saleReceipt->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('sale_receipt_header_id', $saleReceipt->id);
        $detailsDataProvider = new CActiveDataProvider('SaleReceiptDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'invoiceHeader:resetScope' => array(
                'with' => array('orderHeader:resetScope'),
            ),
        );

        $this->render('view', array(
            'saleReceipt' => $saleReceipt,
            'customer' => $customer,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $this->layout = '//layouts/blank';
        
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['SaleReceiptMemoAllowed']) && Yii::app()->session['SaleReceiptMemoAllowed'] === true)) {
                $this->redirect(array('admin'));
            }
        }

        Yii::app()->session->remove('SaleReceiptMemoAllowed');

        $saleReceipt = $this->loadModel($id);

        $customer = $saleReceipt->customer(array('scopes' => 'resetScope'));
        $branch = $saleReceipt->branch(array('scopes' => 'resetScope'));

        $saleReceiptDetails = $saleReceipt->saleReceiptDetails(array(
            'with' => array(
                'invoiceHeader:resetScope' => array(
                    'with' => 'orderHeader:resetScope',
                ),
            ),
        ));

        $this->render('memo', array(
            'saleReceipt' => $saleReceipt,
            'customer' => $customer,
            'branch' => $branch,
            'saleReceiptDetails' => $saleReceiptDetails,
        ));
    }

    public function actionReport() {
        $saleReceiptHeader = Search::bind(new SaleReceiptHeader('search'), isset($_GET['SaleReceiptHeader']) ? $_GET['SaleReceiptHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleReceiptReport = new SaleReceiptReport($saleReceiptHeader->search());
        $saleReceiptReport->setupLoading();
        $saleReceiptReport->setupPaging($pageSize, $currentPage);
        $saleReceiptReport->setupSorting();
        $saleReceiptReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'saleReceiptReport' => $saleReceiptReport,
            'saleReceiptHeader' => $saleReceiptHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $saleReceipt = Search::bind(new SaleReceiptHeader('search'), isset($_GET['SaleReceiptHeader']) ? $_GET['SaleReceiptHeader'] : array());
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $saleReceiptDeliveryDate = (isset($_GET['SaleReceiptDeliveryDate'])) ? $_GET['SaleReceiptDeliveryDate'] : '';

        $dataProvider = $saleReceipt->search();
        $dataProvider->criteria->with = array(
            'customer:resetScope',
            'branch:resetScope',
        );
        
        if (!empty($saleReceiptDeliveryDate)) {
            $dataProvider->criteria->addCondition('t.delivery_date = :delivery_date');
            $dataProvider->criteria->params[':delivery_date'] = $saleReceiptDeliveryDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;
        
        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('saleReceiptEdit')) {
            $buttonTemplate .= '{update}';
        }
        
        if (Yii::app()->user->checkAccess('administrator')) {
            $buttonTemplate .= '{delete}';
        }

        $this->render('admin', array(
            'saleReceipt' => $saleReceipt,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $saleReceiptHeader = $this->loadModel($id);
            
            if ($saleReceiptHeader !== null) {
                $saleReceiptHeader->is_inactive = !$saleReceiptHeader->is_inactive;
                $saleReceiptHeader->update(array('is_inactive'));
                
                if (count($saleReceiptHeader->saleReceiptDetails) > 0) {
                    foreach ($saleReceiptHeader->saleReceiptDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                    }
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id);
            $this->loadState($saleReceipt);

            if (isset($_POST['selectedIds'])) {
                $invoiceIds = array();
                $invoiceIds = $_POST['selectedIds'];

                foreach ($invoiceIds as $invoiceId) {
                    $saleReceipt->addInvoice($invoiceId);
                }
            }
            $error = false;

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt,
                'error' => $error,
            ));
        }
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['SaleReceiptHeader']['customer_id'])) ? $_POST['SaleReceiptHeader']['customer_id'] : '';

            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_company' => CHtml::value($customer, 'company'),
                'customer_address_1' => CHtml::value($customer, 'address_1'),
                'customer_city' => CHtml::value($customer, 'city'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id);

            $this->loadState($saleReceipt);

            $saleReceipt->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlResetDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id);

            $this->loadState($saleReceipt);

            if (isset($_POST['SaleReceiptHeader']['customer_id']))
                $saleReceipt->resetDetail();

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt,
                'error' => false,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $saleReceipt = new SaleReceipt(new SaleReceiptHeader(), array());
        else {
            $saleReceiptHeader = $this->loadModel($id);
            $saleReceipt = new SaleReceipt($saleReceiptHeader, $saleReceiptHeader->saleReceiptDetails);
        }

        return $saleReceipt;
    }

    public function loadModel($id) {
        $model = SaleReceiptHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($saleReceipt) {
        if (isset($_POST['SaleReceiptHeader'])) {
            $saleReceipt->header->attributes = $_POST['SaleReceiptHeader'];
        }
        if (isset($_POST['SaleReceiptDetail'])) {
            foreach ($_POST['SaleReceiptDetail'] as $i => $item) {
                if (isset($saleReceipt->details[$i]))
                    $saleReceipt->details[$i]->attributes = $item;
                else {
                    $detail = new SaleReceiptDetail();
                    $detail->attributes = $item;
                    $saleReceipt->details[] = $detail;
                }
            }
            if (count($_POST['SaleReceiptDetail']) < count($saleReceipt->details))
                array_splice($saleReceipt->details, $i + 1);
        }
        else
            $saleReceipt->details = array();
    }

}

?>
