<?php

class PurchaseReturnController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxJsonReceive' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $purchaseReturn = $this->instantiate(null);
        $purchaseReturn->header->number = CodeNumber::make($purchaseReturn->header, 'number', 'PRET', Yii::app()->user);
        $purchaseReturn->header->admin_id = Yii::app()->user->id;
        $purchaseReturn->header->branch_id = Yii::app()->user->branch_id;

        $this->loadState($purchaseReturn);

        $purchaseNumber = isset($_GET['PurchaseNumber']) ? $_GET['PurchaseNumber'] : '';
        $supplierId = isset($_GET['SupplierId']) ? $_GET['SupplierId'] : '';
        
        $receiveHeader = Search::bind(new ReceiveHeader('search'), isset($_GET['ReceiveHeader']) ? $_GET['ReceiveHeader'] : array());
        $dataProvider = $receiveHeader->searchByPurchaseReturn();
        $dataProvider->criteria->with = array(
            'purchaseHeader' => array(
                'with' => array('supplier'),
            ),
        );

        $dataProvider->criteria->order = 't.date DESC';

        if (!empty($supplierId)) {
            $dataProvider->criteria->addCondition('supplier.id = :supplier_id');
            $dataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (!empty($purchaseNumber)) {
            $dataProvider->criteria->addCondition('purchaseHeader.number LIKE :purchase_header');
            $dataProvider->criteria->params[':purchase_header'] = "%{$purchaseNumber}%";
        }
        
        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($purchaseReturn);
            if ($purchaseReturn->save(Yii::app()->db)) {
                Yii::app()->session['PurchaseReturnMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $purchaseReturn->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'purchaseReturn' => $purchaseReturn,
            'receiveHeader' => $receiveHeader,
            'supplierId' => $supplierId,
            'purchaseNumber' => $purchaseNumber,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $purchaseReturn = $this->instantiate($id);

        $purchaseReturn->header->admin_id = Yii::app()->user->id;

        $receiveHeader = Search::bind(new ReceiveHeader('search'), isset($_GET['ReceiveHeader']) ? $_GET['ReceiveHeader'] : array());
        $dataProvider = $receiveHeader->search();
        $dataProvider->criteria->with = array(
            'purchaseHeader:resetScope' => array(
                'with' => 'supplier:resetScope',
            ),
        );

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($purchaseReturn);
            if ($purchaseReturn->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $purchaseReturn->header->id));
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'purchaseReturn' => $purchaseReturn,
            'receiveHeader' => $receiveHeader,
            'dataProvider' => $dataProvider,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $purchaseReturnHeader = $this->loadModel($id);

        $receiveHeader = $purchaseReturnHeader->receiveHeader(array('scopes' => 'resetScope'));
        $purchaseHeader = $receiveHeader->purchaseHeader(array(
            'scopes' => 'resetScope',
            'with' => 'supplier:resetScope',
        ));
        
        $warehouse = $purchaseReturnHeader->warehouse(array('scopes' => 'resetScope'));
        $branch = $purchaseReturnHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('purchase_return_header_id', $purchaseReturnHeader->id);
        
        $detailsDataProvider = new CActiveDataProvider('PurchaseReturnDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'product:resetScope',
            'unit:resetScope'
        );

        $newProductsDataProvider = new CActiveDataProvider('PurchaseReturnNewProduct');
        $newProductsDataProvider->criteria->compare('purchase_return_header_id', $purchaseReturnHeader->id);

        $this->render('view', array(
            'purchaseReturnHeader' => $purchaseReturnHeader,
            'receiveHeader' => $receiveHeader,
            'purchaseHeader' => $purchaseHeader,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
            'newProductsDataProvider' => $newProductsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['PurchaseReturnMemoAllowed']) && Yii::app()->session['PurchaseReturnMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('PurchaseReturnMemoAllowed');

        $purchaseReturn = $this->loadModel($id);

        $receiveHeader = $purchaseReturn->receiveHeader(array('scopes' => 'resetScope'));
        $purchaseHeader = $receiveHeader->purchaseHeader(array(
            'scopes' => 'resetScope',
            'with' => 'supplier:resetScope',
                ));
        $warehouse = $purchaseReturn->warehouse(array('scopes' => 'resetScope'));
        $branch = $purchaseReturn->branch(array('scopes' => 'resetScope'));

        $purchaseReturnDetails = $purchaseReturn->purchaseReturnDetails(array(
            'with' => array(
                'product:resetScope',
                'unit:resetScope'
            ),
                ));

        $this->render('memo', array(
            'purchaseReturn' => $purchaseReturn,
            'receiveHeader' => $receiveHeader,
            'purchaseHeader' => $purchaseHeader,
            'warehouse' => $warehouse,
            'branch' => $branch,
            'purchaseReturnDetails' => $purchaseReturnDetails,
        ));
    }

    public function actionReport() {
        $purchaseReturnHeader = Search::bind(new PurchaseReturnHeader('search'), isset($_GET['PurchaseReturnHeader']) ? $_GET['PurchaseReturnHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseReturnReport = new PurchaseReturnReport($purchaseReturnHeader->search());
        $purchaseReturnReport->setupLoading();
        $purchaseReturnReport->setupPaging($pageSize, $currentPage);
        $purchaseReturnReport->setupSorting();
        $purchaseReturnReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'purchaseReturnReport' => $purchaseReturnReport,
            'purchaseReturnHeader' => $purchaseReturnHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $purchaseReturn = Search::bind(new PurchaseReturnHeader('search'), isset($_GET['PurchaseReturnHeader']) ? $_GET['PurchaseReturnHeader'] : array());

        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $purchaseReturnHeaderDate = (isset($_GET['PurchaseReturnHeaderDate'])) ? $_GET['PurchaseReturnHeaderDate'] : '';

        $dataProvider = $purchaseReturn->search();
        $dataProvider->criteria->with = array(
            'receiveHeader:resetScope' => array(
                'with' => array(
                    'purchaseHeader:resetScope' => array(
                        'with' => 'supplier:resetScope',
                    ),
                ),
            ),
            'warehouse:resetScope',
            'branch:resetScope',
        );

        if (!empty($supplierId)) {
            $dataProvider->criteria->addCondition('purchaseHeader.supplier_id = :supplier_id');
            $dataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (!empty($purchaseReturnHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $purchaseReturnHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('purchaseReturnEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'purchaseReturn' => $purchaseReturn,
            'supplierId' => $supplierId,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $purchaseReturn = $this->loadModel($id);
            
            if ($purchaseReturn !== null) {
                $purchaseReturn->is_inactive = !$purchaseReturn->is_inactive;
                $purchaseReturn->update(array('is_inactive'));
                
                if (count($purchaseReturn->purchaseReturnDetails) > 0) {
                    foreach ($purchaseReturn->purchaseReturnDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $detail->update(array('is_inactive'));
                    }
                }
                
                if (count($purchaseReturn->purchaseReturnNewProducts) > 0) {
                    foreach ($purchaseReturn->purchaseReturnNewProducts as $detail) {
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

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReturn = $this->instantiate($id);
            $this->loadState($purchaseReturn);

            if (isset($_POST['PurchaseReturnHeader']['receive_header_id']))
                $purchaseReturn->addDetail($_POST['PurchaseReturnHeader']['receive_header_id']);

            $this->renderPartial('_detail', array(
                'purchaseReturn' => $purchaseReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReturn = $this->instantiate($id);
            $this->loadState($purchaseReturn);

            $purchaseReturn->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'purchaseReturn' => $purchaseReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlAddNewProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReturn = $this->instantiate($id);
            $this->loadState($purchaseReturn);

            if (isset($_POST['PurchaseReturnHeader']['receive_header_id']))
                $purchaseReturn->addNewProduct($_POST['PurchaseReturnHeader']['receive_header_id']);

            $this->renderPartial('_newProduct', array(
                'purchaseReturn' => $purchaseReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReturn = $this->instantiate($id);
            $this->loadState($purchaseReturn);

            $purchaseReturn->removeNewProductAt($index);

            $this->renderPartial('_newProduct', array(
                'purchaseReturn' => $purchaseReturn,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonReceive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveId = (isset($_POST['PurchaseReturnHeader']['receive_header_id'])) ? $_POST['PurchaseReturnHeader']['receive_header_id'] : '';

            $receive = ReceiveHeader::model()->findByPk($receiveId);
            $purchaseHeader = $receive->purchaseHeader(array('scopes' => 'resetScope', 'with' => 'supplier:resetScope'));

            $object = array(
                'receive_header_number' => CHtml::value($receive, 'number'),
                'supplier_name' => CHtml::value($purchaseHeader, 'supplier.name'),
                'supplier_company' => CHtml::value($purchaseHeader, 'supplier.company'),
                'supplier_address' => CHtml::value($purchaseHeader, 'supplier.address'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonTotalDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReturn = $this->instantiate($id);

            $this->loadState($purchaseReturn);

            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseReturn->details[$index]->getTotal($_POST['PurchaseReturnHeader']['receive_header_id'])));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseReturn->getGrandTotal($_POST['PurchaseReturnHeader']['receive_header_id'])));

            echo CJSON::encode(array(
                'total' => $total,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function actionAjaxJsonTotalNewProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReturn = $this->instantiate($id);

            $this->loadState($purchaseReturn);

            $totalNewProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseReturn->newProducts[$index]->getTotal($_POST['PurchaseReturnHeader']['receive_header_id'])));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseReturn->getGrandTotal($_POST['PurchaseReturnHeader']['receive_header_id'])));

            echo CJSON::encode(array(
                'totalNewProduct' => $totalNewProduct,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $purchaseReturn = new PurchaseReturn(new PurchaseReturnHeader(), array(), array());
        else {
            $purchaseReturnHeader = $this->loadModel($id);
            $purchaseReturn = new PurchaseReturn($purchaseReturnHeader, $purchaseReturnHeader->purchaseReturnDetails, $purchaseReturnHeader->purchaseReturnNewProducts);
        }

        return $purchaseReturn;
    }

    public function loadModel($id) {
        $model = PurchaseReturnHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($purchaseReturn) {
        if (isset($_POST['PurchaseReturnHeader'])) {
            $purchaseReturn->header->attributes = $_POST['PurchaseReturnHeader'];
        }
        
        if (isset($_POST['PurchaseReturnDetail'])) {
            foreach ($_POST['PurchaseReturnDetail'] as $i => $item) {
                if (isset($purchaseReturn->details[$i]))
                    $purchaseReturn->details[$i]->attributes = $item;
                else {
                    $detail = new PurchaseReturnDetail();
                    $detail->attributes = $item;
                    $purchaseReturn->details[] = $detail;
                }
            }
            if (count($_POST['PurchaseReturnDetail']) < count($purchaseReturn->details))
                array_splice($purchaseReturn->details, $i + 1);
        }
        else
            $purchaseReturn->details = array();
        
        if (isset($_POST['PurchaseReturnNewProduct'])) {
            foreach ($_POST['PurchaseReturnNewProduct'] as $i => $item) {
                if (isset($purchaseReturn->newProducts[$i]))
                    $purchaseReturn->newProducts[$i]->attributes = $item;
                else {
                    $detail = new PurchaseReturnNewProduct();
                    $detail->attributes = $item;
                    $purchaseReturn->newProducts[] = $detail;
                }
            }
            if (count($_POST['PurchaseReturnNewProduct']) < count($purchaseReturn->newProducts))
                array_splice($purchaseReturn->newProducts, $i + 1);
        }
        else
            $purchaseReturn->newProducts = array();
    }

}

?>