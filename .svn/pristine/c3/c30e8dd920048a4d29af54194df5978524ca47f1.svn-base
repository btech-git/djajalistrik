<?php

class ReceiveController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('receiveCreate') || Yii::app()->user->checkAccess('receiveEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxJsonPurchase' || $filterChain->action->id === 'ajaxHtmlAddPurchase' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('receiveCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('receiveEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('receiveReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $receive = $this->instantiate(null);
        $receive->header->number = CodeNumber::make($receive->header, 'number', 'RCV', Yii::app()->user);
        $receive->header->admin_id = Yii::app()->user->id;
        $receive->header->branch_id = Yii::app()->user->branch_id;

        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
//        $supplierId = isset($_GET['SupplierId']) ? $_GET['SupplierId'] : '';
        $orderNumber = isset($_GET['OrderNumber']) ? $_GET['OrderNumber'] : '';

        $purchase = Search::bind(new PurchaseHeader('search'), isset($_GET['PurchaseHeader']) ? $_GET['PurchaseHeader'] : array());
        $dataProvider = $purchase->searchByReceive();
        $dataProvider->criteria->with = array(
            'orderHeader' => array(
                'with' => array(
                    'customer'
                ),
            ),
            'supplier',
        );

        $dataProvider->criteria->order = 't.id DESC';

        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition('orderHeader.customer_id = :customer_id');
            $dataProvider->criteria->params[':customer_id'] = $customerId;
        }
        
        if (!empty($orderNumber)) {
            $dataProvider->criteria->addCondition('orderHeader.reference_number LIKE :order_header');
            $dataProvider->criteria->params[':order_header'] = "%{$orderNumber}%";
        }
        
        $error = false;
        
        if (isset($_POST['Submit'])) {
            $this->loadState($receive);
            
            if ($receive->save(Yii::app()->db)) {
                Yii::app()->session['ReceiveMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $receive->header->id));
            } else {
                $error = true;
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'receive' => $receive,
            'purchase' => $purchase,
            'dataProvider' => $dataProvider,
            'customerId' => $customerId,
            'orderNumber' => $orderNumber,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $receive = $this->instantiate($id);

        $receive->header->admin_id = Yii::app()->user->id;

        $purchase = Search::bind(new PurchaseHeader('search'), isset($_GET['PurchaseHeader']) ? $_GET['PurchaseHeader'] : array());
        $dataProvider = $purchase->search();
        $dataProvider->criteria->with = array(
            'orderHeader:resetScope',
            'supplier:resetScope',
        );

        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($receive);
            if ($receive->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $receive->header->id));
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'receive' => $receive,
            'purchase' => $purchase,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $receiveHeader = $this->loadModel($id);

        $purchaseHeader = $receiveHeader->purchaseHeader(array('scopes' => 'resetScope', 'with' => 'orderHeader:resetScope'));
        $warehouse = $receiveHeader->warehouse(array('scopes' => 'resetScope'));
        $branch = $receiveHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('receive_header_id', $receiveHeader->id);
        $detailsDataProvider = new CActiveDataProvider('ReceiveDetail', array(
                    'criteria' => $criteria,
                ));

        $detailsDataProvider->criteria->with = array(
            'product:resetScope',
            'unit:resetScope'
        );

        $criteria = new CDbCriteria;
        $criteria->compare('receive_header_id', $receiveHeader->id);
        $newProductsDataProvider = new CActiveDataProvider('ReceiveNewProduct', array(
                    'criteria' => $criteria,
                ));

        $newProductsDataProvider->criteria->with = array(
            'purchaseNewProduct:resetScope',
        );

        $this->render('view', array(
            'receiveHeader' => $receiveHeader,
            'purchaseHeader' => $purchaseHeader,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'newProductsDataProvider' => $newProductsDataProvider,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['ReceiveMemoAllowed']) && Yii::app()->session['ReceiveMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('ReceiveMemoAllowed');

        $receive = $this->loadModel($id);

        $warehouse = $receive->warehouse(array('scopes' => 'resetScope'));
        $branch = $receive->branch(array('scopes' => 'resetScope'));
        $purchaseHeader = $receive->purchaseHeader(array(
            'scopes' => 'resetScope',
            'with' => 'supplier:resetScope',
                ));

        $receiveDetails = $receive->receiveDetails(array(
            'with' => array(
                'product:resetScope',
                'unit:resetScope'
            ),
                ));

        $receiveNewProducts = $receive->receiveNewProducts(array(
            'with' => array(
                'purchaseNewProduct:resetScope',
            ),
                ));



        $this->render('memo', array(
            'receive' => $receive,
            'purchaseHeader' => $purchaseHeader,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'receiveDetails' => $receiveDetails,
            'receiveNewProducts' => $receiveNewProducts,
        ));
    }

    public function actionReport() {
        $receiveHeader = Search::bind(new ReceiveHeader('search'), isset($_GET['ReceiveHeader']) ? $_GET['ReceiveHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $receiveReport = new ReceiveReport($receiveHeader->search());
        $receiveReport->setupLoading();
        $receiveReport->setupPaging($pageSize, $currentPage);
        $receiveReport->setupSorting();
        $receiveReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'receiveReport' => $receiveReport,
            'receiveHeader' => $receiveHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $receive = Search::bind(new ReceiveHeader('search'), isset($_GET['ReceiveHeader']) ? $_GET['ReceiveHeader'] : array());

        $supplierId = isset($_GET['SupplierId']) ? $_GET['SupplierId'] : '';
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $purchaseNumber = isset($_GET['PurchaseNumber']) ? $_GET['PurchaseNumber'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $receiveHeaderDate = (isset($_GET['ReceiveHeaderDate'])) ? $_GET['ReceiveHeaderDate'] : '';

        $dataProvider = $receive->search();
        $dataProvider->criteria->with = array(
            'purchaseHeader' => array(
                'with' => array(
                    'supplier',
                    'orderHeader' => array(
                        'with' => array(
                            'customer'
                        ),
                    ),
                ),
            ),
            'warehouse:resetScope',
            'branch:resetScope',
        );
        
        if (!empty($supplierId)) {
            $dataProvider->criteria->addCondition('supplier.id = :supplier_id');
            $dataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition('customer.id = :customer_id');
            $dataProvider->criteria->params[':customer_id'] = $customerId;
        }
        
        if (!empty($purchaseNumber)) {
            $dataProvider->criteria->addCondition('purchaseHeader.number LIKE :purchase_header');
            $dataProvider->criteria->params[':purchase_header'] = "%{$purchaseNumber}%";
        }
        
        if (!empty($receiveHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $receiveHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('receiveEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'receive' => $receive,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
            'supplierId' => $supplierId,
            'customerId' => $customerId,
            'purchaseNumber' => $purchaseNumber,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $receiveHeader = $this->loadModel($id);
            
            if ($receiveHeader !== null) {
                $receiveHeader->is_inactive = !$receiveHeader->is_inactive;
                $receiveHeader->update(array('is_inactive'));
                
                if (count($receiveHeader->receiveDetails) > 0) {
                    foreach ($receiveHeader->receiveDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                        
                        $purchaseDetail = $detail->purchaseDetail;
                        $purchaseDetail->quantity_receive = $purchaseDetail->totalQuantityReceive;
                        $purchaseDetail->quantity_remaining = $purchaseDetail->quantity - $purchaseDetail->quantity_receive;
                        $valid = $purchaseDetail->update(array('quantity_receive', 'quantity_remaining')) && $valid;
                    }
                }
                
                if (count($receiveHeader->receiveNewProducts) > 0) {
                    foreach ($receiveHeader->receiveNewProducts as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                        
                        $purchaseNewProduct = $detail->purchaseNewProduct;
                        $purchaseNewProduct->quantity_receive = $purchaseNewProduct->totalQuantityReceive;
                        $purchaseNewProduct->quantity_remaining = $purchaseNewProduct->quantity - $purchaseNewProduct->quantity_receive;
                        $valid = $purchaseNewProduct->update(array('quantity_receive', 'quantity_remaining')) && $valid;
                    }
                }
            }

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAjaxJsonPurchase($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseId = (isset($_POST['ReceiveHeader']['purchase_header_id'])) ? $_POST['ReceiveHeader']['purchase_header_id'] : '';

            $purchase = PurchaseHeader::model()->findByPk($purchaseId);
            $supplier = $purchase->supplier(array('scopes' => 'resetScope'));

            $object = array(
                'purchase_number' => CHtml::value($purchase, 'number'),
                'order_header_id' => CHtml::value($purchase, 'orderHeader.reference_number'),
                'supplier_company' => CHtml::value($supplier, 'company'),
                'supplier_name' => CHtml::value($supplier, 'name'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddPurchase($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receive = $this->instantiate($id);

            $this->loadState($receive);

            if (isset($_POST['ReceiveHeader']['purchase_header_id'])) {
                $receive->addDetailByPurchase($_POST['ReceiveHeader']['purchase_header_id']);
                $receive->addNewProductByPurchase($_POST['ReceiveHeader']['purchase_header_id']);
            }

            $this->renderPartial('_detail', array(
                'receive' => $receive,
                'error' => false,
            ));
        }
    }

//	public function actionAjaxHtmlShowPurchaseNewProduct($id)
//	{
//		if (Yii::app()->request->isAjaxRequest)
//		{
//			$receive = $this->instantiate($id);
//
//			$this->loadState($receive);
//
//			if (isset($_POST['ReceiveHeader']['purchase_header_id']))
//				$receive->addNewProductByPurchase($_POST['ReceiveHeader']['purchase_header_id']);
//
//			$this->renderPartial('_detail', array(
//				'receive' => $receive,
//				'error' => false,
//			));
//		}
//	}

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $receive = $this->instantiate($id);

            $this->loadState($receive);

            $receive->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'receive' => $receive,
                'error' => false,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $receive = $this->instantiate($id);

            $this->loadState($receive);

            $receive->removeNewProductAt($index);

            $this->renderPartial('_newProduct', array(
                'receive' => $receive,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $receive = new Receive(new ReceiveHeader(), array(), array());
        else {
            $receiveHeader = $this->loadModel($id);
            $receive = new Receive($receiveHeader, $receiveHeader->receiveDetails(array('scopes' => 'resetScope')), $receiveHeader->receiveNewProducts);
        }

        return $receive;
    }

    public function loadModel($id) {
        $model = ReceiveHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($receive) {
        if (isset($_POST['ReceiveHeader'])) {
            $receive->header->attributes = $_POST['ReceiveHeader'];
        }
        if (isset($_POST['ReceiveDetail'])) {
            foreach ($_POST['ReceiveDetail'] as $i => $item) {
                if (isset($receive->details[$i]))
                    $receive->details[$i]->attributes = $item;
                else {
                    $detail = new ReceiveDetail();
                    $detail->attributes = $item;
                    $receive->details[] = $detail;
                }
            }
            if (count($_POST['ReceiveDetail']) < count($receive->details))
                array_splice($receive->details, $i + 1);
        }
        else
            $receive->details = array();

        if (isset($_POST['ReceiveNewProduct'])) {
            foreach ($_POST['ReceiveNewProduct'] as $i => $item) {
                if (isset($receive->newProducts[$i]))
                    $receive->newProducts[$i]->attributes = $item;
                else {
                    $newProducts = new ReceiveNewProduct();
                    $newProducts->attributes = $item;
                    $receive->newProducts[] = $newProducts;
                }
            }
            if (count($_POST['ReceiveNewProduct']) < count($receive->newProducts))
                array_splice($receive->newProducts, $i + 1);
        }
        else
            $receive->newProducts = array();
    }

}
