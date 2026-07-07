<?php

class PackingListController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create'
            || $filterChain->action->id === 'ajaxHtmlAddProduct'
            || $filterChain->action->id === 'ajaxJsonDiscountTaxTotal'
            || $filterChain->action->id === 'ajaxJsonDownpaymentTaxTotal'
            || $filterChain->action->id === 'ajaxJsonGrandTotal'
            || $filterChain->action->id === 'ajaxHtmlRemoveProduct'
            || $filterChain->action->id === 'ajaxJsonTaxTotal'
            || $filterChain->action->id === 'ajaxJsonTotal'
            || $filterChain->action->id === 'ajaxHtmlUpdateAllProduct'
            || $filterChain->action->id === 'memo'
            || $filterChain->action->id === 'view') {
        if (!(Yii::app()->user->checkAccess('saleCreate')
                || Yii::app()->user->checkAccess('saleEdit')))
            $this->redirect(array('/site/login'));
        }
        if (
            $filterChain->action->id === 'delete'
            || $filterChain->action->id === 'admin'
            || $filterChain->action->id === 'openOrder'
            || $filterChain->action->id === 'processingOrder'
            || $filterChain->action->id === 'waitingForShipment'
            || $filterChain->action->id === 'shipped'
            || $filterChain->action->id === 'completed'
            || $filterChain->action->id === 'followUp'
            || $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleEdit') || Yii::app()->user->checkAccess('saleCreate')))
                $this->redirect(array('/site/login'));
        }
        $filterChain->run();
    }

    public function actionCreate() {
        $packingList = $this->instantiate(null);
        $packingList->header->date = date('Y-m-d');
        $packingList->header->admin_id = Yii::app()->user->id;

        $orderHeader = Search::bind(new OrderHeader('search'), isset($_GET['OrderHeader']) ? $_GET['OrderHeader'] : '');
        $orderHeaderDataProvider = $orderHeader->searchByPackingList();
        $orderHeaderDataProvider->criteria->with = array(
            'customer',
            'branch',
            'admin',
        );

        $orderHeaderDataProvider->criteria->order = 't.id DESC';

        if (isset($_POST['Submit'])) {
            $this->loadState($packingList);
            $packingList->header->number = CodeNumber::make($packingList->header, 'number', 'PL', Yii::app()->user);
            $packingList->header->branch_id = $packingList->header->orderHeader->branch_id;

            if ($packingList->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $packingList->header->id));
            }
        }

        $this->render('create', array(
            'packingList' => $packingList,
            'orderHeader' => $orderHeader,
            'orderHeaderDataProvider' => $orderHeaderDataProvider,
        ));
    }

    public function actionView($id) {
        $packingList = $this->loadModel($id);

        $this->render('view', array(
            'packingList' => $packingList,
        ));
    }

    public function getPackingListDetail($packingList) {
        $listProducts = array();

        foreach ($packingList->packingListDetails as $i => $detail) {
            $orderDetail = $detail->orderDetail;
            if ($orderDetail->is_inactive == 0) {
                $product = $orderDetail->product;
                $product->quantity = $orderDetail->quantity_single;
                $listProducts[] = $product;
            }
        }

        $newProductItemsLists = array();
        $flag_same = FALSE;
        foreach ($listProducts as $listProduct) {
            foreach ($newProductItemsLists as $newProductItemsList) {
                if ($listProduct->id == $newProductItemsList->id) {
                    $newProductItemsList->quantity += $listProduct->quantity;
                    $flag_same = TRUE;
                    break;
                }
                else
                    $flag_same = FALSE;
            }
            if (!$flag_same)
                $newProductItemsLists[] = $listProduct;
        }

        function compare_name($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        }

        // sort alphabetically by name
        usort($newProductItemsLists, 'compare_name');

        return $newProductItemsLists;
    }

    public function actionMemo($id) {
        $this->layout = '//layouts/blank';

        $packingList = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('packingListDetails.is_inactive', 0);
        $criteria->compare('packingListHeader.id', $packingList->id);
        $criteria->group = 't.product_id';

        $this->render('memo', array(
            'packingList' => $packingList,
        ));
    }

    public function actionAdmin() {
        $packingList = Search::bind(new PackingListHeader('search'), isset($_GET['PackingListHeader']) ? $_GET['PackingListHeader'] : array());
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $orderHeader = isset($_GET['OrderHeader']) ? $_GET['OrderHeader'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $packingListHeaderDate = (isset($_GET['PackingListHeaderDate'])) ? $_GET['PackingListHeaderDate'] : '';

        $dataProvider = $packingList->search();
        $dataProvider->criteria->with = array(
            'warehouse',
            'branch',
            'orderHeader' => array(
                'with' => array(
                    'customer',
                )
            )
        );
        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        if (!empty($packingListHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $packingListHeaderDate;
        }

        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition('orderHeader.customer_id = :customer_company');
            $dataProvider->criteria->params[':customer_company'] = $customerId;
        }

        if (!empty($orderHeader)) {
            $dataProvider->criteria->addCondition('orderHeader.reference_number LIKE :order_header');
            $dataProvider->criteria->params[':order_header'] = "%{$orderHeader}%";
        }

        $this->render('admin', array(
            'packingList' => $packingList,
            'dataProvider' => $dataProvider,
            'customerId' => $customerId,
            'orderHeader' => $orderHeader,
        ));
    }

    public function actionUpdate($id) {
        $packingList = $this->instantiate($id);

        $orderHeader = Search::bind(new OrderHeader('search'), isset($_GET['OrderHeader']) ? $_GET['OrderHeader'] : '');
        $orderHeaderDataProvider = $orderHeader->searchByPackingList();
        $orderHeaderDataProvider->criteria->with = array(
            'customer' => array(
                'with' => array(
                    'discountCategory',
                ),
            ),
            'branch',
            'admin',
        );

        $orderHeaderDataProvider->criteria->compare('t.is_inactive', 0);
        $orderHeaderDataProvider->criteria->order = 't.id DESC';

        if (isset($_POST['Submit'])) {
            $this->loadState($packingList);
            
            if ($packingList->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $packingList->header->id));
        }

        $this->render('update', array(
            'packingList' => $packingList,
            'orderHeader' => $orderHeader,
            'orderHeaderDataProvider' => $orderHeaderDataProvider,
        ));
    }

    public function actionAjaxJsonOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $orderId = (isset($_POST['PackingListHeader']['order_header_id'])) ? $_POST['PackingListHeader']['order_header_id'] : '';

            $order = OrderHeader::model()->findByPk($orderId);
            $customer = $order->customer(array('scopes' => 'resetScope'));

            $object = array(
                'order_number' => CHtml::value($order, 'number'),
                'order_date' => Yii::app()->dateFormatter->format("d MMMM yyyy", $order->date),
                'order_admin' => CHtml::value($order, 'admin.name'),
                'customer_name' => CHtml::value($customer, 'company'),
                'customer_address_1' => CHtml::value($customer, 'address_1'),
                'reference_number' => CHtml::value($order, 'reference_number'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $packingList = $this->instantiate($id);
            $this->loadState($packingList);

            if (isset($_POST['PackingListHeader']['order_header_id']))
                $packingList->addDetail($_POST['PackingListHeader']['order_header_id']);

            $this->renderPartial('_detail', array(
                'packingList' => $packingList,
            ));
        }
    }

    public function actionAjaxHtmlAddDetailNewProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $packingList = $this->instantiate($id);
            $this->loadState($packingList);

            if (isset($_POST['PackingListHeader']['order_header_id']))
                $packingList->addNewProduct($_POST['PackingListHeader']['order_header_id']);

            $this->renderPartial('_newProduct', array(
                'packingList' => $packingList,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $packingList = $this->instantiate($id);
            $this->loadState($packingList);

            $packingList->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'packingList' => $packingList,
            ));
        }
    }

    public function actionAjaxHtmlUpdateAllProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $packingList = $this->instantiate($id);
            $this->loadState($packingList);

            $packingList->updateProducts();

            $this->renderPartial('_detail', array(
                'packingList' => $packingList,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $packingList = new PackingList(new PackingListHeader(), array());
        else {
            $header = $this->loadModel($id);
            $packingList = new PackingList($header, $header->packingListDetails);
        }

        return $packingList;
    }

    public function loadModel($id) {
        $packingList = PackingListHeader::model()->findByPk($id);
        if ($packingList === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $packingList;
    }

    public function loadState(&$packingList) {
        if (isset($_POST['PackingListHeader'])) {
            $packingList->header->attributes = $_POST['PackingListHeader'];
        }
        
        if (isset($_POST['PackingListDetail'])) {
            foreach ($_POST['PackingListDetail'] as $i => $item) {
                if (isset($packingList->details[$i]))
                    $packingList->details[$i]->attributes = $item;
                else {
                    $detail = new PackingListDetail();
                    $detail->attributes = $item;
                    $packingList->details[] = $detail;
                }
            }
            if (count($_POST['PackingListDetail']) < count($packingList->details))
                array_splice($packingList->details, $i + 1);
        }
        else
            $packingList->details = array();
    }

}