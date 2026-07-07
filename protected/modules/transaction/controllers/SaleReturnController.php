<?php

class SaleReturnController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('saleReturnCreate') || Yii::app()->user->checkAccess('saleReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddOrder' || $filterChain->action->id === 'ajaxJsonOrder' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('saleReturnCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('saleReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('saleReturnReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $saleReturn = $this->instantiate(null);
        $saleReturn->header->number = CodeNumber::make($saleReturn->header, 'number', 'SRET', Yii::app()->user);
        $saleReturn->header->admin_id = Yii::app()->user->id;
        $saleReturn->header->branch_id = Yii::app()->user->branch_id;

        $deliveryHeader = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());
        $dataProvider = $deliveryHeader->searchBySaleReturn();
        $dataProvider->criteria->with = array(
            'orderHeader' => array(
                'with' => array(
                    'customer',
                )
            )
        );

        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $orderNumber = isset($_GET['OrderNumber']) ? $_GET['OrderNumber'] : '';

        if (!empty($customerId)) {
            $dataProvider->criteria->compare('orderHeader.customer_id', $customerId);
        }

        if (!empty($orderNumber)) {
            $dataProvider->criteria->compare('orderHeader.reference_number', $orderNumber, true);
        }

        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($saleReturn);

            if ($saleReturn->save(Yii::app()->db)) {
//				Yii::app()->session['SaleReturnMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $saleReturn->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'saleReturn' => $saleReturn,
            'deliveryHeader' => $deliveryHeader,
            'customerId' => $customerId,
            'orderNumber' => $orderNumber,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $saleReturn = $this->instantiate($id);

        $saleReturn->header->admin_id = Yii::app()->user->id;

        $deliveryHeader = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());
        $dataProvider = $deliveryHeader->searchBySaleReturn();
        $dataProvider->criteria->with = array(
            'orderHeader' => array(
                'with' => array(
                    'customer',
                )
            )
        );

        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $orderNumber = isset($_GET['OrderNumber']) ? $_GET['OrderNumber'] : '';

        if (!empty($customerId)) {
            $dataProvider->criteria->compare('orderHeader.customer_id', $customerId);
        }

        if (!empty($orderNumber)) {
            $dataProvider->criteria->compare('orderHeader.reference_number', $orderNumber, true);
        }

        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($saleReturn);

            if ($saleReturn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleReturn->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'saleReturn' => $saleReturn,
            'deliveryHeader' => $deliveryHeader,
            'customerId' => $customerId,
            'orderNumber' => $orderNumber,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $saleReturnHeader = $this->loadModel($id);

        $orderHeader = $saleReturnHeader->deliveryHeader->orderHeader(array(
            'scopes' => 'resetScope',
            'with' => 'customer:resetScope',
        ));
        $warehouse = $saleReturnHeader->warehouse(array('scopes' => 'resetScope'));
        $branch = $saleReturnHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('sale_return_header_id', $saleReturnHeader->id);
        
        $detailsDataProvider = new CActiveDataProvider('SaleReturnDetail', array(
            'criteria' => $criteria,
        ));

        $newProductsDataProvider = new CActiveDataProvider('SaleReturnNewProduct', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'saleReturnHeader' => $saleReturnHeader,
            'orderHeader' => $orderHeader,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
            'newProductsDataProvider' => $newProductsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['SaleReturnMemoAllowed']) && Yii::app()->session['SaleReturnMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('SaleReturnMemoAllowed');

        $saleReturn = $this->loadModel($id);

        $orderHeader = $saleReturn->deliveryHeader->orderHeader(array(
            'scopes' => 'resetScope',
            'with' => 'customer:resetScope',
        ));
        $warehouse = $saleReturn->warehouse(array('scopes' => 'resetScope'));
        $branch = $saleReturn->branch(array('scopes' => 'resetScope'));

        $saleReturnDetails = $saleReturn->saleReturnDetails(array(
            'with' => array(
                'deliveryDetail' => array(
                    'with' => array(
                        'orderDetail',
                        'unit:resetScope'
                    ),
                ),
            ),
        ));

        $this->render('memo', array(
            'saleReturn' => $saleReturn,
            'orderHeader' => $orderHeader,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'saleReturnDetails' => $saleReturnDetails,
        ));
    }

    public function actionReport() {
        $saleReturnHeader = Search::bind(new SaleReturnHeader('search'), isset($_GET['SaleReturnHeader']) ? $_GET['SaleReturnHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleReturnReport = new SaleReturnReport($saleReturnHeader->search());
        $saleReturnReport->setupLoading();
        $saleReturnReport->setupPaging($pageSize, $currentPage);
        $saleReturnReport->setupSorting();
        $saleReturnReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'saleReturnReport' => $saleReturnReport,
            'saleReturnHeader' => $saleReturnHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $saleReturn = Search::bind(new SaleReturnHeader('search'), isset($_GET['SaleReturnHeader']) ? $_GET['SaleReturnHeader'] : array());

        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $orderNumber = isset($_GET['OrderNumber']) ? $_GET['OrderNumber'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $saleReturnHeaderDate = (isset($_GET['SaleReturnHeaderDate'])) ? $_GET['SaleReturnHeaderDate'] : '';

        $dataProvider = $saleReturn->search();
        $dataProvider->criteria->with = array(
            'deliveryHeader:resetScope' => array(
                'with' => array(
                    'orderHeader:resetScope' => array(
                        'with' => array(
                            'customer:resetScope'
                        ),
                    ),
                ),
            ),
            'warehouse:resetScope',
            'branch:resetScope',
        );

        if (!empty($customerId)) {
            $dataProvider->criteria->compare('orderHeader.customer_id', $customerId);
        }

        if (!empty($orderNumber)) {
            $dataProvider->criteria->compare('orderHeader.reference_number', $orderNumber, true);
        }

        if (!empty($saleReturnHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $saleReturnHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('saleReturnEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'saleReturn' => $saleReturn,
            'customerId' => $customerId,
            'orderNumber' => $orderNumber,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $saleReturn = $this->loadModel($id);
            
            if ($saleReturn !== null) {
                $saleReturn->is_inactive = !$saleReturn->is_inactive;
                $saleReturn->update(array('is_inactive'));
                
                if (count($saleReturn->saleReturnDetails) > 0) {
                    foreach ($saleReturn->saleReturnDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                    }
                }
                
                if (count($saleReturn->saleReturnNewProducts) > 0) {
                    foreach ($saleReturn->saleReturnNewProducts as $detail) {
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

    public function actionAjaxHtmlAddOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReturn = $this->instantiate($id);
            $this->loadState($saleReturn);

            if (isset($_POST['SaleReturnHeader']['delivery_header_id']))
                $saleReturn->addDetail($_POST['SaleReturnHeader']['delivery_header_id']);

            $this->renderPartial('_detail', array(
                'saleReturn' => $saleReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReturn = $this->instantiate($id);
            $this->loadState($saleReturn);

            $saleReturn->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'saleReturn' => $saleReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlAddNewProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReturn = $this->instantiate($id);
            $this->loadState($saleReturn);

            if (isset($_POST['SaleReturnHeader']['delivery_header_id']))
                $saleReturn->addNewProduct($_POST['SaleReturnHeader']['delivery_header_id']);

            $this->renderPartial('_newProduct', array(
                'saleReturn' => $saleReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReturn = $this->instantiate($id);
            $this->loadState($saleReturn);

            $saleReturn->removeNewProductAt($index);

            $this->renderPartial('_newProduct', array(
                'saleReturn' => $saleReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $orderId = (isset($_POST['SaleReturnHeader']['delivery_header_id'])) ? $_POST['SaleReturnHeader']['delivery_header_id'] : '';

            $order = DeliveryHeader::model()->findByPk($orderId);
            $customer = $order->orderHeader->customer(array('scopes' => 'resetScope'));

            $object = array(
                'order_number' => CHtml::value($order, 'number'),
                'customer_name' => CHtml::value($customer, 'name'),
                'dalivery_date' => CHtml::value($order, 'date'),
                'reference_number' => CHtml::value($order, 'orderHeader.reference_number'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReturn = $this->instantiate($id);
            $this->loadState($saleReturn);

            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->details[$index]->getTotal()));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->getGrandTotal()));

            echo CJSON::encode(array(
                'total' => $total,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function actionAjaxJsonTotalNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReturn = $this->instantiate($id);
            $this->loadState($saleReturn);

            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->newProducts[$index]->getTotal()));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->getGrandTotalNewProduct()));

            echo CJSON::encode(array(
                'totalNewProduct' => $total,
                'grandTotalNewProduct' => $grandTotal,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $saleReturn = new SaleReturn(new SaleReturnHeader(), array(), array());
        else {
            $saleReturnHeader = $this->loadModel($id);
            $saleReturn = new SaleReturn($saleReturnHeader, $saleReturnHeader->saleReturnDetails(array('scopes' => 'resetScope')), $saleReturnHeader->saleReturnNewProducts(array('scopes' => 'resetScope')));
        }

        return $saleReturn;
    }

    public function loadModel($id) {
        $model = SaleReturnHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($saleReturn) {
        if (isset($_POST['SaleReturnHeader'])) {
            $saleReturn->header->attributes = $_POST['SaleReturnHeader'];
        }
        
        if (isset($_POST['SaleReturnDetail'])) {
            foreach ($_POST['SaleReturnDetail'] as $i => $item) {
                if (isset($saleReturn->details[$i]))
                    $saleReturn->details[$i]->attributes = $item;
                else {
                    $detail = new SaleReturnDetail();
                    $detail->attributes = $item;
                    $saleReturn->details[] = $detail;
                }
            }
            if (count($_POST['SaleReturnDetail']) < count($saleReturn->details))
                array_splice($saleReturn->details, $i + 1);
        }
        else
            $saleReturn->details = array();
        
        if (isset($_POST['SaleReturnNewProduct'])) {
            foreach ($_POST['SaleReturnNewProduct'] as $i => $item) {
                if (isset($saleReturn->newProducts[$i]))
                    $saleReturn->newProducts[$i]->attributes = $item;
                else {
                    $detail = new SaleReturnNewProduct();
                    $detail->attributes = $item;
                    $saleReturn->newProducts[] = $detail;
                }
            }
            if (count($_POST['SaleReturnNewProduct']) < count($saleReturn->newProducts))
                array_splice($saleReturn->newProducts, $i + 1);
        }
        else
            $saleReturn->newProducts = array();
    }

}

?>
