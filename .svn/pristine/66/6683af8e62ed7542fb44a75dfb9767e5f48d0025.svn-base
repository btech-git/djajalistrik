<?php

class PurchaseController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxJsonSupplier' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxJsonOrder' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxHtmlAddOrder') {
            if (!(Yii::app()->user->checkAccess('purchaseCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('purchaseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchaseReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $purchase = $this->instantiate(null);
        $purchase->header->number = CodeNumber::make($purchase->header, 'number', 'PRC', Yii::app()->user);
        $purchase->header->admin_id = Yii::app()->user->id;

        $customerId = isset($_GET['PurchaseHeader']['customer_id']) ? $_GET['PurchaseHeader']['customer_id'] : '';
        $orderHeader = Search::bind(new OrderHeader('search'), isset($_GET['OrderHeader']) ? $_GET['OrderHeader'] : array());

        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';

        $orderDataProvider = $orderHeader->searchByPurchase();
        $orderDataProvider->criteria->with = array(
            'customer',
            'branch',
        );

        $orderDataProvider->criteria->addCondition("customer.name LIKE :name");
        $orderDataProvider->criteria->params[':name'] = "%{$customerName}%";

        $orderDataProvider->criteria->order = 't.id DESC';

        if (!empty($customerId)) {
            $orderDataProvider->criteria->addCondition("customer_id = :customer_id");
            $orderDataProvider->criteria->params[':customer_id'] = $customerId;
        }

        $productCategoryMainId = isset($_GET['ProductCategoryMainId']) ? $_GET['ProductCategoryMainId'] : '';
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->criteria->with = array(
            'productCategoryIdSingle'
        );
        $productDataProvider->criteria->compare('productCategoryMain.id', $productCategoryMainId);

        $productDataProvider->criteria->order = 't.name ASC';

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($purchase);
            
            if ($purchase->save(Yii::app()->db)) {
                Yii::app()->session['PurchaseMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $purchase->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'purchase' => $purchase,
            'product' => $product,
            'supplier' => $supplier,
            'customer' => $customer,
            'productDataProvider' => $productDataProvider,
            'productCategoryMainId' => $productCategoryMainId,
            'error' => $error,
            'orderHeader' => $orderHeader,
            'orderDataProvider' => $orderDataProvider,
            'customerName' => $customerName,
        ));
    }

    public function actionUpdate($id) {
        $purchase = $this->instantiate($id);
        $purchase->header->admin_edit_list = ltrim($purchase->header->admin_edit_list . ',' . Yii::app()->user->id, ',');

        $productCategoryMainId = isset($_GET['ProductCategoryMainId']) ? $_GET['ProductCategoryMainId'] : '';
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->criteria->with = array(
            'productCategoryIdSingle:resetScope' => array(
                'with' => array('productCategoryMain:resetScope'),
            ),
        );
        $productDataProvider->criteria->compare('productCategoryMain.id', $productCategoryMainId);

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($purchase);
            
            if ($purchase->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $purchase->header->id));
            } else {
                $error = true;
            }
        }
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('create'));
        }

        $this->render('update', array(
            'purchase' => $purchase,
            'product' => $product,
            'supplier' => $supplier,
            'customer' => $customer,
            'productDataProvider' => $productDataProvider,
            'productCategoryMainId' => $productCategoryMainId,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $purchaseHeader = $this->loadModel($id);

        $orderHeader = $purchaseHeader->orderHeader(array('scopes' => 'resetScope'));
        $supplier = $purchaseHeader->supplier(array('scopes' => 'resetScope'));
        $customer = $purchaseHeader->customer(array('scopes' => 'resetScope'));
        $currency = $purchaseHeader->currency(array('scopes' => 'resetScope'));
        $branch = $purchaseHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('purchase_header_id', $purchaseHeader->id);
        $detailsDataProvider = new CActiveDataProvider('PurchaseDetail', array(
                    'criteria' => $criteria,
                ));

        $detailsDataProvider->criteria->with = array(
            'product:resetScope',
            'unit:resetScope'
        );

        $detailsDataProvider->criteria->order = 't.id ASC';

        $criteria = new CDbCriteria;
        $criteria->compare('purchase_header_id', $purchaseHeader->id);
        $newProductsDataProvider = new CActiveDataProvider('PurchaseNewProduct', array(
                    'criteria' => $criteria,
                ));

        $newProductsDataProvider->criteria->order = 't.id ASC';

        if (isset($_POST['Update'])) {
            $purchaseHeader->is_approved = 1;
            if ($purchaseHeader->save())
                $this->redirect(array('view', 'id' => $purchaseHeader->id));
        }

        if (isset($_POST['Cleared'])) {
            $purchaseHeader->is_hold = 1;
            if ($purchaseHeader->save())
                $this->redirect(array('view', 'id' => $purchaseHeader->id));
        }

        if (isset($_POST['Hold'])) {
            $purchaseHeader->is_hold = 2;
            if ($purchaseHeader->save())
                $this->redirect(array('view', 'id' => $purchaseHeader->id));
        }

        if (isset($_POST['Canceled'])) {
            $purchaseHeader->is_hold = 3;
            if ($purchaseHeader->save())
                $this->redirect(array('view', 'id' => $purchaseHeader->id));
        }

        $this->render('view', array(
            'purchaseHeader' => $purchaseHeader,
            'orderHeader' => $orderHeader,
            'supplier' => $supplier,
            'customer' => $customer,
            'currency' => $currency,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
            'newProductsDataProvider' => $newProductsDataProvider,
        ));
    }

    public function actionMemo($id) {
//		if (!(Yii::app()->user->checkAccess('administrator')))
//        {
//            if (!(isset(Yii::app()->session['PurchaseMemoAllowed']) && Yii::app()->session['PurchaseMemoAllowed'] === true))
//                $this->redirect(array('admin'));
//        }
//
//        Yii::app()->session->remove('PurchaseMemoAllowed');

        $purchase = $this->loadModel($id);

        $supplier = $purchase->supplier(array('scopes' => 'resetScope'));
        $customer = $purchase->customer(array('scopes' => 'resetScope'));
        $currency = $purchase->currency(array('scopes' => 'resetScope'));
        $branch = $purchase->branch(array('scopes' => 'resetScope'));
        $order = $purchase->orderHeader(array(
            'scopes' => 'resetScope',
            'with' => 'customer:resetScope',
                ));

        $purchaseDetails = $purchase->purchaseDetails(array(
            'with' => array(
                'product:resetScope',
                'unit:resetScope'
            ),
            'order' => 'purchaseDetails.id ASC',
                ));

        $purchaseNewProducts = $purchase->purchaseNewProducts(array(
            'with' => array(
                'unit:resetScope',
                'brand:resetScope',
            ),
            'order' => 'purchaseNewProducts.id ASC',
                ));

        $discountDetailHiddenStatuses = array_fill(1, 5, true);
        foreach ($purchaseDetails as $detail) {
            $discountDetailHiddenStatuses[1] = $discountDetailHiddenStatuses[1] && ((int) $detail->discount_1 === 0);
            $discountDetailHiddenStatuses[2] = $discountDetailHiddenStatuses[2] && ((int) $detail->discount_2 === 0);
            $discountDetailHiddenStatuses[3] = $discountDetailHiddenStatuses[3] && ((int) $detail->discount_3 === 0);
            $discountDetailHiddenStatuses[4] = $discountDetailHiddenStatuses[4] && ((int) $detail->discount_4 === 0);
            $discountDetailHiddenStatuses[5] = $discountDetailHiddenStatuses[5] && ((int) $detail->discount_5 === 0);
        }

        $discountNewProductHiddenStatuses = array_fill(1, 5, true);
        foreach ($purchaseNewProducts as $newProduct) {
            $discountNewProductHiddenStatuses[1] = $discountNewProductHiddenStatuses[1] && ((int) $newProduct->discount_1 === 0);
            $discountNewProductHiddenStatuses[2] = $discountNewProductHiddenStatuses[2] && ((int) $newProduct->discount_2 === 0);
            $discountNewProductHiddenStatuses[3] = $discountNewProductHiddenStatuses[3] && ((int) $newProduct->discount_3 === 0);
            $discountNewProductHiddenStatuses[4] = $discountNewProductHiddenStatuses[4] && ((int) $newProduct->discount_4 === 0);
            $discountNewProductHiddenStatuses[5] = $discountNewProductHiddenStatuses[5] && ((int) $newProduct->discount_5 === 0);
        }

        $this->render('memo', array(
            'purchase' => $purchase,
            'currency' => $currency,
            'branch' => $branch,
            'order' => $order,
            'supplier' => $supplier,
            'customer' => $customer,
            'purchaseDetails' => $purchaseDetails,
            'purchaseNewProducts' => $purchaseNewProducts,
            'discountDetailHiddenStatuses' => $discountDetailHiddenStatuses,
            'discountNewProductHiddenStatuses' => $discountNewProductHiddenStatuses,
        ));
    }

    public function actionReport() {
        $purchaseHeader = Search::bind(new PurchaseHeader('search'), isset($_GET['PurchaseHeader']) ? $_GET['PurchaseHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseReport = new PurchaseReport($purchaseHeader->search());
        $purchaseReport->setupLoading();
        $purchaseReport->setupPaging($pageSize, $currentPage);
        $purchaseReport->setupSorting();
        $purchaseReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'purchaseReport' => $purchaseReport,
            'purchaseHeader' => $purchaseHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $purchase = Search::bind(new PurchaseHeader('search'), isset($_GET['PurchaseHeader']) ? $_GET['PurchaseHeader'] : array());

//        $supplierName = isset($_GET['SupplierName']) ? $_GET['SupplierName'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $purchaseHeaderDate = (isset($_GET['PurchaseHeaderDate'])) ? $_GET['PurchaseHeaderDate'] : '';
        $orderNumber = isset($_GET['OrderNumber']) ? $_GET['OrderNumber'] : '';

        $dataProvider = $purchase->resetScope()->search();
        $dataProvider->criteria->with = array(
            'orderHeader:resetScope',
            'currency:resetScope',
            'supplier:resetScope',
            'branch:resetScope',
        );
        
//        if (!empty($supplierName)) {
//            $dataProvider->criteria->addCondition('supplier.name LIKE :supplier_name');
//            $dataProvider->criteria->params[':supplier_name'] = "%{$supplierName}%";
//        }
        
        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;
        
        if (!empty($purchaseHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $purchaseHeaderDate;
        }

        if (!empty($orderNumber)) {
            $dataProvider->criteria->addCondition('orderHeader.reference_number LIKE :order_header');
            $dataProvider->criteria->params[':order_header'] = "%{$orderNumber}%";
        }
        
        $buttonTemplate = '';
        if (Yii::app()->user->checkAccess('purchaseEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'purchase' => $purchase,
            'dataProvider' => $dataProvider,
//            'supplierName' => $supplierName,
            'orderNumber' => $orderNumber,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $purchaseHeader = $this->loadModel($id);
            $receiveHeader = ReceiveHeader::model()->findByAttributes(array('purchase_header_id' => $id, 'is_inactive' => 0));
            
            if ($purchaseHeader !== null && empty($receiveHeader)) {
                $purchaseHeader->is_inactive = !$purchaseHeader->is_inactive;
                $purchaseHeader->update(array('is_inactive'));
                
                if (count($purchaseHeader->purchaseDetails) > 0) {
                    foreach ($purchaseHeader->purchaseDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                    }
                }
                
                if (count($purchaseHeader->purchaseNewProducts) > 0) {
                    foreach ($purchaseHeader->purchaseNewProducts as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                    }
                }
                
                Yii::app()->user->setFlash('success', "Data is deleted!");
                
            } else {
                Yii::app()->user->setFlash('failed', "Data can't be deleted!");
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            if (isset($_POST['ProductId']))
                $purchase->addDetail($_POST['ProductId']);

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlAddNewProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->addNewProduct();

            $this->renderPartial('_newProduct', array(
                'purchase' => $purchase,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $object = array(
                'unit_price' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->details[$index], 'unit_price')),
                'price_after_discount' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->details[$index], 'priceAfterDiscount')),
                'total' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->details[$index], 'total')),
                'totalDetail' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'totalDetail')),
                'subTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'subTotal')),
                'tax' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'totalTax')),
                'grandTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'grandTotal')),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonTotalNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $object = array(
                'unit_price' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->newProducts[$index], 'unit_price')),
                'price_after_discount' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->newProducts[$index], 'priceAfterDiscount')),
                'total' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->newProducts[$index], 'total')),
                'totalNewProduct' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'totalNewProduct')),
                'subTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'subTotal')),
                'tax' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'totalTax')),
                'grandTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'grandTotal')),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);
            $this->loadState($purchase);

            $object = array(
                'subTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'subTotal')),
                'tax' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'totalTax')),
                'grandTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'grandTotal')),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $purchase = $this->instantiate($id);
            $this->loadState($purchase);

            $order = $purchase->header->orderHeader(array('scopes' => 'resetScope', 'with' => 'customer:resetScope'));

            $object = array(
                'order_header_codeNumber' => CHtml::value($order, 'number'),
                'customer_name' => CHtml::value($order, 'customer.name'),
                'customer_purchase_number' => CHtml::value($order, 'reference_number'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonResetOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $order = $purchase->header->orderHeader(array('scopes' => 'resetScope', 'with' => 'customer:resetScope'));

            $object = array(
                'order_header_codeNumber' => '',
                'PurchaseHeader_order_header_id' => '',
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['PurchaseHeader']['supplier_id'])) ? $_POST['PurchaseHeader']['supplier_id'] : '';

            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'company'),
                'supplier_address' => CHtml::value($supplier, 'address'),
                'supplier_city' => CHtml::value($supplier, 'city'),
                'supplier_phone' => CHtml::value($supplier, 'phone'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['PurchaseHeader']['customer_id'])) ? $_POST['PurchaseHeader']['customer_id'] : '';

            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlResetDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->resetDetail();

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            $purchase->removeNewProductAt($index);

            $this->renderPartial('_newProduct', array(
                'purchase' => $purchase,
            ));
        }
    }

    public function actionAjaxHtmlAddOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);
            $this->loadState($purchase);

            if (isset($_POST['PurchaseHeader']['order_header_id']))
                $purchase->addDetailByOrder($_POST['PurchaseHeader']['order_header_id']);

            $this->renderPartial('_detail', array(
                'purchase' => $purchase,
                'error' => false,
            ));
        }
    }
    
    public function actionAjaxHtmlAddOrderNewProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchase = $this->instantiate($id);

            $this->loadState($purchase);

            if (isset($_POST['PurchaseHeader']['order_header_id']))
                $purchase->addNewProductByOrder($_POST['PurchaseHeader']['order_header_id']);

            $this->renderPartial('_newProduct', array(
                'purchase' => $purchase,
                'error' => false,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $purchase = new Purchase(new PurchaseHeader(), array(), array());
        else {
            $purchaseHeader = $this->loadModel($id);
            $purchase = new Purchase($purchaseHeader, $purchaseHeader->purchaseDetails(array('scopes' => 'resetScope')), $purchaseHeader->purchaseNewProducts(array('scopes' => 'resetScope')));
        }

        return $purchase;
    }

    public function loadModel($id) {
        $model = PurchaseHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($purchase) {
        if (isset($_POST['PurchaseHeader'])) {
            $purchase->header->attributes = $_POST['PurchaseHeader'];
        }
        if (isset($_POST['PurchaseDetail'])) {
            foreach ($_POST['PurchaseDetail'] as $i => $item) {
                if (isset($purchase->details[$i]))
                    $purchase->details[$i]->attributes = $item;
                else {
                    $detail = new PurchaseDetail();
                    $detail->attributes = $item;
                    $purchase->details[] = $detail;
                }
            }
            if (count($_POST['PurchaseDetail']) < count($purchase->details))
                array_splice($purchase->details, $i + 1);
        }
        else
            $purchase->details = array();

        if (isset($_POST['PurchaseNewProduct'])) {
            foreach ($_POST['PurchaseNewProduct'] as $i => $item) {
                if (isset($purchase->newProducts[$i]))
                    $purchase->newProducts[$i]->attributes = $item;
                else {
                    $detail = new PurchaseNewProduct();
                    $detail->attributes = $item;
                    $purchase->newProducts[] = $detail;
                }
            }
            if (count($_POST['PurchaseNewProduct']) < count($purchase->newProducts))
                array_splice($purchase->newProducts, $i + 1);
        }
        else
            $purchase->newProducts = array();
    }

}
