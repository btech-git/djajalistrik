<?php

class DeliveryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddDetail' || $filterChain->action->id === 'ajaxJsonOrder' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'updateAllProduct' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('deliveryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionOrderList() {

        $orderHeader = Search::bind(new OrderHeader('search'), isset($_GET['OrderHeader']) ? $_GET['OrderHeader'] : '');
        $orderHeaderDataProvider = $orderHeader->searchByDelivery();
        $orderHeaderDataProvider->criteria->with = array(
            'customer',
            'branch',
            'admin'
        );

        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        if (!empty($customerCompany)) {
            $orderHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $orderHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }

        $orderHeaderDataProvider->criteria->order = 't.date DESC';

        $this->render('orderList', array(
            'orderHeader' => $orderHeader,
            'orderHeaderDataProvider' => $orderHeaderDataProvider,
            'customerCompany' => $customerCompany,
        ));
    }

    public function actionCreate($orderHeaderId) {
        $delivery = $this->instantiate(null);
        $orderHeader = OrderHeader::model()->findByPk($orderHeaderId);

        $delivery->header->date = date('Y-m-d');
        $delivery->header->admin_id = Yii::app()->user->id;
        $delivery->header->branch_id = $orderHeader->branch_id;
        $delivery->header->order_header_id = $orderHeaderId;

        $packingListDetail = Search::bind(new PackingListDetail('search'), isset($_GET['PackingListDetail']) ? $_GET['PackingListDetail'] : array());
        $packingListDetailDataProvider = $packingListDetail->searchForDelivery();

        $packingListDetailDataProvider->criteria->with = array(
            'packingListHeader' => array(
                'with' => array(
                    'orderHeader' => array(
                        'with' => array(
                            'customer'
                        ),
                    ),
                ),
            ),
        );

        if (!empty($orderHeaderId)) {
            $packingListDetailDataProvider->criteria->addCondition("packingListHeader.order_header_id = :order_header_id");
            $packingListDetailDataProvider->criteria->params[':order_header_id'] = $orderHeaderId;
        }

        $orderNewProduct = Search::bind(new OrderNewProduct('search'), isset($_GET['OrderNewProduct']) ? $_GET['OrderNewProduct'] : array());
        $orderNewProductDataProvider = $orderNewProduct->searchForDelivery();

        $orderNewProductDataProvider->criteria->with = array(
            'orderHeader'
        );

        if (!empty($orderHeaderId)) {
            $orderNewProductDataProvider->criteria->addCondition("t.order_header_id = :order_header_id");
            $orderNewProductDataProvider->criteria->params[':order_header_id'] = $orderHeaderId;
        }

        if (isset($_POST['Submit'])) {
            $this->loadState($delivery);
            $delivery->header->number = CodeNumber::make($delivery->header, 'number', 'DLV', Yii::app()->user, $delivery->header->branch_id);
                
            if ($delivery->save(Yii::app()->db)) {
                Yii::app()->session['DeliveryMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $delivery->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'delivery' => $delivery,
            'orderHeader' => $orderHeader,
            'packingListDetail' => $packingListDetail,
            'packingListDetailDataProvider' => $packingListDetailDataProvider,
            'orderNewProduct' => $orderNewProduct,
            'orderNewProductDataProvider' => $orderNewProductDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $delivery = $this->instantiate($id);
        $orderHeader = OrderHeader::model()->findByPk($delivery->header->order_header_id);

        $delivery->header->admin_id = Yii::app()->user->id;

        $packingListDetail = Search::bind(new PackingListDetail('search'), isset($_GET['PackingListDetail']) ? $_GET['PackingListDetail'] : array());
        $packingListDetailDataProvider = $packingListDetail->searchForDelivery();

        $packingListDetailDataProvider->criteria->with = array(
            'packingListHeader' => array(
                'with' => array(
                    'orderHeader' => array(
                        'with' => array(
                            'customer'
                        ),
                    ),
                ),
            ),
        );

        if (!empty($orderHeader)) {
            $packingListDetailDataProvider->criteria->addCondition("packingListHeader.order_header_id = :order_header_id");
            $packingListDetailDataProvider->criteria->params[':order_header_id'] = $orderHeader->id;
        }

        $orderNewProduct = Search::bind(new OrderNewProduct('search'), isset($_GET['OrderNewProduct']) ? $_GET['OrderNewProduct'] : array());
        $orderNewProductDataProvider = $orderNewProduct->searchForDelivery();

        $orderNewProductDataProvider->criteria->with = array(
            'orderHeader'
        );

        if (!empty($orderHeader->id)) {
            $orderNewProductDataProvider->criteria->addCondition("t.order_header_id = :order_header_id");
            $orderNewProductDataProvider->criteria->params[':order_header_id'] = $orderHeader->id;
        }

        if (isset($_POST['Submit'])) {
            $this->loadState($delivery);
            
            if ($delivery->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $delivery->header->id));
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'delivery' => $delivery,
            'orderHeader' => $orderHeader,
            'packingListDetail' => $packingListDetail,
            'packingListDetailDataProvider' => $packingListDetailDataProvider,
            'orderNewProduct' => $orderNewProduct,
            'orderNewProductDataProvider' => $orderNewProductDataProvider,
        ));
    }

    public function actionView($id) {
        $deliveryHeader = $this->loadModel($id);

        $orderHeader = $deliveryHeader->orderHeader(array('scopes' => 'resetScope'));
        $warehouse = $deliveryHeader->warehouse(array('scopes' => 'resetScope'));
        $branch = $deliveryHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('delivery_header_id', $deliveryHeader->id);
        $detailsDataProvider = new CActiveDataProvider('DeliveryDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'orderDetail:resetScope',
            'unit:resetScope'
        );

        $criteria = new CDbCriteria;
        $criteria->compare('delivery_header_id', $deliveryHeader->id);

        $newProductsDataProvider = new CActiveDataProvider('DeliveryNewProduct', array(
            'criteria' => $criteria,
        ));

        $newProductsDataProvider->criteria->with = array(
            'orderNewProduct:resetScope',
        );

        $this->render('view', array(
            'deliveryHeader' => $deliveryHeader,
            'detailsDataProvider' => $detailsDataProvider,
            'newProductsDataProvider' => $newProductsDataProvider,
            'orderHeader' => $orderHeader,
            'branch' => $branch,
            'warehouse' => $warehouse,
        ));
    }

    public function actionMemo($id) {
        $this->layout = '//layouts/blank';
        
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['DeliveryMemoAllowed']) && Yii::app()->session['DeliveryMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('DeliveryMemoAllowed');

        $delivery = $this->loadModel($id);

        $warehouse = $delivery->warehouse(array('scopes' => 'resetScope'));
        $branch = $delivery->branch(array('scopes' => 'resetScope'));
        $order = $delivery->orderHeader(array(
            'scopes' => 'resetScope',
            'with' => 'customer:resetScope',
        ));

        $deliveryDetails = $delivery->deliveryDetails(array(
            'with' => array(
                'orderDetail:resetScope',
                'unit:resetScope'
            ),
        ));

        $deliveryNewProducts = $delivery->deliveryNewProducts(array(
            'with' => array(
                'orderNewProduct:resetScope',
            ),
        ));

        $this->render('memo', array(
            'delivery' => $delivery,
            'order' => $order,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'deliveryDetails' => $deliveryDetails,
            'deliveryNewProducts' => $deliveryNewProducts,
        ));
    }

    public function actionReport() {
        $deliveryHeader = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliveryReport = new DeliveryReport($deliveryHeader->search());
        $deliveryReport->setupLoading();
        $deliveryReport->setupPaging($pageSize, $currentPage);
        $deliveryReport->setupSorting();
        $deliveryReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'deliveryReport' => $deliveryReport,
            'deliveryHeader' => $deliveryHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $delivery = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());

        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $orderNumber = isset($_GET['OrderNumber']) ? $_GET['OrderNumber'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $deliveryHeaderDate = (isset($_GET['DeliveryHeaderDate'])) ? $_GET['DeliveryHeaderDate'] : '';
        
        $dataProvider = $delivery->search();
        $dataProvider->criteria->with = array(
            'orderHeader' => array(
                'with' => array(
                    'customer',
                ),
            ),
            'warehouse',
            'branch',
        );
        
        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition('orderHeader.customer_id = :customer_company');
            $dataProvider->criteria->params[':customer_company'] = $customerId;
        }
        
        if (!empty($orderNumber)) {
            $dataProvider->criteria->addCondition('orderHeader.reference_number LIKE :order_header');
            $dataProvider->criteria->params[':order_header'] = "%{$orderNumber}%";
        }
        
        if (!empty($deliveryHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $deliveryHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('deliveryEdit')) {
            $buttonTemplate .= '{update}';
        }
        
        if (Yii::app()->user->checkAccess('administrator')) {
            $buttonTemplate .= '{delete}';
        }

        $this->render('admin', array(
            'delivery' => $delivery,
            'dataProvider' => $dataProvider,
            'orderNumber' => $orderNumber,
            'customerId' => $customerId,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $deliveryHeader = $this->loadModel($id);
            
            if ($deliveryHeader !== null) {
                $deliveryHeader->is_inactive = ActiveRecord::INACTIVE;
                $deliveryHeader->update(array('is_inactive'));
                
                if (count($deliveryHeader->deliveryDetails) > 0) {
                    foreach ($deliveryHeader->deliveryDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                    }
                }
                
                if (count($deliveryHeader->deliveryNewProducts) > 0) {
                    foreach ($deliveryHeader->deliveryNewProducts as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
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

    public function actionAjaxHtmlAddPackingLists($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);
            $this->loadState($delivery);

            if (isset($_POST['selectedIds'])) {
                $packingLists = array();
                $packingLists = $_POST['selectedIds'];

                foreach ($packingLists as $packingList) {
                    $delivery->addPackingList($packingList);
                }
            }

            $this->renderPartial('_detail', array(
                'delivery' => $delivery,
            ));
        }
    }

    public function actionAjaxHtmlAddReceives($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);
            $this->loadState($delivery);

            if (isset($_POST['selectedReceiveIds'])) {
                $receives = array();
                $receives = $_POST['selectedReceiveIds'];

                foreach ($receives as $receive)
                    $delivery->addReceive($receive);
            }

            $this->renderPartial('_newProduct', array(
                'delivery' => $delivery,
            ));
        }
    }

    public function actionAjaxJsonOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            
            $packingListId = (isset($_POST['DeliveryHeader']['packing_list_header_id'])) ? $_POST['DeliveryHeader']['packing_list_header_id'] : '';
            $packingList = PackingListHeader::model()->findByPk($packingListId);

            $object = array(
                'packing_list_number' => CHtml::value($packingList, 'number'),
                'packing_list_date' => Yii::app()->dateFormatter->format("d MMMM yyyy", $packingList->date),
                'order_number' => CHtml::value($packingList, 'orderHeader.reference_number'),
                'order_date' => Yii::app()->dateFormatter->format("d MMMM yyyy", $packingList->orderHeader->date),
                'order_admin' => CHtml::value($packingList, 'admin.name'),
                'customer_name' => CHtml::value($packingList, 'orderHeader.customer.name'),
                'customer_address' => CHtml::value($packingList, 'orderHeader.customer.address_1'),
                'order_id' => $packingList->orderHeader->id,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);
            $this->loadState($delivery);
            
            $delivery->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'delivery' => $delivery,
                'error' => false,
            ));
        }
    }

    Public function actionAjaxHtmlUpdateAllProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);
            $this->loadState($delivery);

            $delivery->updateProducts();

            $this->renderPartial('_detail', array(
                'delivery' => $delivery,
                'error' => false,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $delivery = new Delivery(new DeliveryHeader(), array(), array());
        else {
            $deliveryHeader = $this->loadModel($id);
            $delivery = new Delivery($deliveryHeader, $deliveryHeader->deliveryDetails(array('scopes' => 'resetScope')), $deliveryHeader->deliveryNewProducts(array('scopes' => 'resetScope')));
        }

        return $delivery;
    }

    public function loadModel($id) {
        $model = DeliveryHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($delivery) {
        if (isset($_POST['DeliveryHeader'])) {
            $delivery->header->attributes = $_POST['DeliveryHeader'];
        }
        if (isset($_POST['DeliveryDetail'])) {
            foreach ($_POST['DeliveryDetail'] as $i => $item) {
                if (isset($delivery->details[$i]))
                    $delivery->details[$i]->attributes = $item;
                else {
                    $detail = new DeliveryDetail();
                    $detail->attributes = $item;
                    $delivery->details[] = $detail;
                }
            }
            if (count($_POST['DeliveryDetail']) < count($delivery->details))
                array_splice($delivery->details, $i + 1);
        }
        else
            $delivery->details = array();

        if (isset($_POST['DeliveryNewProduct'])) {
            foreach ($_POST['DeliveryNewProduct'] as $i => $item) {
                if (isset($delivery->newProducts[$i]))
                    $delivery->newProducts[$i]->attributes = $item;
                else {
                    $detail = new DeliveryNewProduct();
                    $detail->attributes = $item;
                    $delivery->newProducts[] = $detail;
                }
            }
            if (count($_POST['DeliveryNewProduct']) < count($delivery->newProducts))
                array_splice($delivery->newProducts, $i + 1);
        }
        else
            $delivery->newProducts = array();
    }

}

?>
