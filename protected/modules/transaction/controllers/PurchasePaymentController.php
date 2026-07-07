<?php

class PurchasePaymentController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'ajaxJsonPurchaseReceipt' || $filterChain->action->id === 'ajaxHtmlSummary' || $filterChain->action->id === 'ajaxHtmlAddPayment' || $filterChain->action->id === 'ajaxHtmlRemovePayment' || $filterChain->action->id === 'ajaxHtmlResetPayment' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentCreate') || Yii::app()->user->checkAccess('purchasePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $purchasePayment = $this->instantiate(null);
        $purchasePayment->header->number = CodeNumber::make($purchasePayment->header, 'number', 'PPY', Yii::app()->user);
        $purchasePayment->header->admin_id = Yii::app()->user->id;
        $purchasePayment->header->branch_id = Yii::app()->user->branch_id;

        $purchaseReceipt = Search::bind(new PurchaseReceiptHeader('search'), isset($_GET['PurchaseReceiptHeader']) ? $_GET['PurchaseReceiptHeader'] : array());
        $dataProvider = $purchaseReceipt->searchByPurchasePayment();
        $dataProvider->criteria->with = array(
            'supplier:resetScope',
        );

        $dataProvider->criteria->order = 't.id DESC';

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($purchasePayment);
            
            if ($purchasePayment->save(Yii::app()->db)) {
                Yii::app()->session['PurchasePaymentMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $purchasePayment->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'purchasePayment' => $purchasePayment,
            'purchaseReceipt' => $purchaseReceipt,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $purchasePayment = $this->instantiate($id);

        $purchaseReceipt = Search::bind(new PurchaseReceiptHeader('search'), isset($_GET['PurchaseReceiptHeader']) ? $_GET['PurchaseReceiptHeader'] : array());
        $dataProvider = $purchaseReceipt->searchByPurchasePayment();
        $dataProvider->criteria->with = array(
            'supplier:resetScope',
        );

        $dataProvider->criteria->order = 't.id DESC';

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($purchasePayment);
            
            if ($purchasePayment->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $purchasePayment->header->id));
            else
                $error = true;
        }
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }
        $this->render('update', array(
            'purchasePayment' => $purchasePayment,
            'purchaseReceipt' => $purchaseReceipt,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $purchasePayment = $this->loadModel($id);

        $purchaseReceiptHeader = $purchasePayment->purchaseReceiptHeader(array('scopes' => 'resetScope'));
        $branch = $purchasePayment->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('purchase_payment_header_id', $purchasePayment->id);
        $detailsDataProvider = new CActiveDataProvider('PurchasePaymentDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'paymentType:resetScope'
        );

        $this->render('view', array(
            'purchasePayment' => $purchasePayment,
            'purchaseReceiptHeader' => $purchaseReceiptHeader,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['PurchasePaymentMemoAllowed']) && Yii::app()->session['PurchasePaymentMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('PurchasePaymentMemoAllowed');

        $purchasePayment = $this->loadModel($id);

        $branch = $purchasePayment->branch(array('scopes' => 'resetScope'));
        $purchaseHeader = $purchasePayment->purchaseReceiptHeader(array(
            'scopes' => 'resetScope',
            'with' => 'supplier:resetScope',
        ));

        $purchasePaymentDetails = $purchasePayment->purchasePaymentDetails(array(
            'with' => array(
                'paymentType:resetScope'
            ),
        ));

        $this->render('memo', array(
            'purchasePayment' => $purchasePayment,
            'purchaseHeader' => $purchaseHeader,
            'branch' => $branch,
            'purchasePaymentDetails' => $purchasePaymentDetails,
        ));
    }

    public function actionAdmin() {
        $purchasePayment = Search::bind(new PurchasePaymentHeader('search'), isset($_GET['PurchasePaymentHeader']) ? $_GET['PurchasePaymentHeader'] : array());

        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $purchaseReceiptHeaderDate = (isset($_GET['PurchaseReceiptHeaderDate'])) ? $_GET['PurchaseReceiptHeaderDate'] : '';
        
        $dataProvider = $purchasePayment->search();
        $dataProvider->criteria->with = array(
            'purchaseReceiptHeader' => array(
                'with' => array('supplier:resetScope'),
            ),
            'branch:resetScope',
        );

        if (!empty($supplierId)) {
            $dataProvider->criteria->addCondition('purchaseReceiptHeader.supplier_id = :supplier_id');
            $dataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (!empty($purchaseReceiptHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $purchaseReceiptHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('purchasePaymentEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'purchasePayment' => $purchasePayment,
            'supplierId' => $supplierId,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $purchasePaymentHeader = $this->loadModel($id);
            
            if ($purchasePaymentHeader !== null) {
                $purchasePaymentHeader->is_inactive = !$purchasePaymentHeader->is_inactive;
                $purchasePaymentHeader->update(array('is_inactive'));
                
                if (count($purchasePaymentHeader->purchasePaymentDetails) > 0) {
                    foreach ($purchasePaymentHeader->purchasePaymentDetails as $detail) {
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

    public function actionAjaxJsonPurchaseReceipt($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchasePayment = $this->instantiate($id);
            $this->loadState($purchasePayment);

            $purchaseReceiptHeader = $purchasePayment->header->purchaseReceiptHeader(array(
                'scopes' => 'resetScope',
                'with' => array(
                    'supplier',
                ),
            ));

            $object = array(
                'purchase_number' => CHtml::value($purchaseReceiptHeader, 'number'),
                'purchase_date' => CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($purchaseReceiptHeader, 'date'))),
                'purchase_supplier' => CHtml::value($purchaseReceiptHeader, 'supplier.company'),
                'grand_total' => CHtml::value($purchaseReceiptHeader, 'remaining'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonSummary($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchasePayment = $this->instantiate($id);

            $this->loadState($purchasePayment);

            $amount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment->details[$index], 'amount')));
            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment, 'totalReceipt')));
            $payment = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment, 'totalPayment')));
            $remaining = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment, 'remaining')));
//			$total_payment = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment, 'totalPayment')));

            echo CJSON::encode(array(
                'amount' => $amount,
                'total' => $total,
                'payment' => $payment,
                'remaining' => $remaining,
//				'total_payment' => $total_payment,
            ));
        }
    }

    public function actionAjaxHtmlAddPayment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchasePayment = $this->instantiate($id);

            $this->loadState($purchasePayment);

            if (isset($_POST['PurchasePaymentHeader']['purchase_receipt_header_id']))
                $purchasePayment->addDetail($_POST['PurchasePaymentHeader']['purchase_receipt_header_id']);

            $this->renderPartial('_detail', array(
                'purchasePayment' => $purchasePayment,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemovePayment($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchasePayment = $this->instantiate($id);

            $this->loadState($purchasePayment);

            $purchasePayment->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'purchasePayment' => $purchasePayment,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlResetPayment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchasePayment = $this->instantiate($id);

            $this->loadState($purchasePayment);

            if (isset($_POST['PurchasePaymentHeader']['purchase_receipt_header_id']))
                $purchasePayment->resetPayment($_POST['PurchasePaymentHeader']['purchase_receipt_header_id']);

            $this->renderPartial('_detail', array(
                'purchasePayment' => $purchasePayment,
                'error' => false,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $purchasePayment = new PurchasePayment(new PurchasePaymentHeader(), array());
        else {
            $purchasePaymentHeader = $this->loadModel($id);
            $purchasePayment = new PurchasePayment($purchasePaymentHeader, $purchasePaymentHeader->purchasePaymentDetails);
        }

        return $purchasePayment;
    }

    public function loadModel($id) {
        $model = PurchasePaymentHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($purchasePayment) {
        if (isset($_POST['PurchasePaymentHeader'])) {
            $purchasePayment->header->attributes = $_POST['PurchasePaymentHeader'];
        }
        if (isset($_POST['PurchasePaymentDetail'])) {
            foreach ($_POST['PurchasePaymentDetail'] as $i => $item) {
                if (isset($purchasePayment->details[$i]))
                    $purchasePayment->details[$i]->attributes = $item;
                else {
                    $detail = new PurchasePaymentDetail();
                    $detail->attributes = $item;
                    $purchasePayment->details[] = $detail;
                }
            }
            if (count($_POST['PurchasePaymentDetail']) < count($purchasePayment->details))
                array_splice($purchasePayment->details, $i + 1);
        }
        else
            $purchasePayment->details = array();
    }

}

?>
