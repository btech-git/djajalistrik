<?php

class TransferController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'updateAllProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('transferCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('transferReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $transfer = $this->instantiate(null);
        $transfer->header->number = CodeNumber::make($transfer->header, 'number', 'TRF', Yii::app()->user);
        $transfer->header->admin_id = Yii::app()->user->id;
        $transfer->header->branch_id = Yii::app()->user->branch_id;

        $productCategoryMainId = isset($_GET['ProductCategoryMainId']) ? $_GET['ProductCategoryMainId'] : '';
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $dataProvider = $product->search();
        $dataProvider->criteria->with = array(
            'productCategoryIdSingle:resetScope' => array(
                'with' => array('productCategoryMain:resetScope'),
            ),
        );
        $dataProvider->criteria->compare('productCategoryMain.id', $productCategoryMainId);

        $dataProvider->criteria->order = 't.name ASC';

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($transfer);
            if ($transfer->save(Yii::app()->db)) {
                Yii::app()->session['TransferMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $transfer->header->id));
            }
            else
                $error = true;
        }

        $this->render('create', array(
            'transfer' => $transfer,
            'product' => $product,
            'dataProvider' => $dataProvider,
            'productCategoryMainId' => $productCategoryMainId,
            'error' => $error,
        ));
    }

    public function actionAdmin() {
        $transferHeader = Search::bind(new TransferHeader('search'), isset($_GET['TransferHeader']) ? $_GET['TransferHeader'] : array());
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $transferHeaderDate = (isset($_GET['TransferHeaderDate'])) ? $_GET['TransferHeaderDate'] : '';

        $dataProvider = $transferHeader->search();
        $dataProvider->criteria->with = array(
            'warehouseIdFrom',
            'warehouseIdTo',
            'branch',
            'admin',
        );

        if (!empty($transferHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $transferHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('deliveryEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'transferHeader' => $transferHeader,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionView($id) {
        $transferHeader = $this->loadModel($id);

        $warehouseIdFrom = $transferHeader->warehouseIdFrom(array('scopes' => 'resetScope'));
        $warehouseIdTo = $transferHeader->warehouseIdTo(array('scopes' => 'resetScope'));
        $branch = $transferHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('transfer_header_id', $transferHeader->id);
        $detailsDataProvider = new CActiveDataProvider('TransferDetail', array(
                    'criteria' => $criteria,
                ));

        $detailsDataProvider->criteria->with = array(
            'product:resetScope',
            'unit:resetScope'
        );

        $this->render('view', array(
            'transferHeader' => $transferHeader,
            'warehouseIdFrom' => $warehouseIdFrom,
            'warehouseIdTo' => $warehouseIdTo,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['TransferMemoAllowed']) && Yii::app()->session['TransferMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('TransferMemoAllowed');

        $transfer = $this->loadModel($id);

        $warehouseIdForm = $transfer->warehouseIdFrom(array('scopes' => 'resetScope'));
        $warehouseIdTo = $transfer->warehouseIdTo(array('scopes' => 'resetScope'));
        $branch = $transfer->branch(array('scopes' => 'resetScope'));

        $transferDetails = $transfer->transferDetails(array(
            'with' => array(
                'product:resetScope',
                'unit:resetScope'
            ),
                ));


        $this->render('memo', array(
            'transfer' => $transfer,
            'warehouseIdForm' => $warehouseIdForm,
            'warehouseIdTo' => $warehouseIdTo,
            'branch' => $branch,
            'transferDetails' => $transferDetails,
        ));
    }

    public function actionReport() {
        $transferHeader = Search::bind(new TransferHeader('search'), isset($_GET['TransferHeader']) ? $_GET['TransferHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $transferReport = new TransferReport($transferHeader->search());
        $transferReport->setupLoading();
        $transferReport->setupPaging($pageSize, $currentPage);
        $transferReport->setupSorting();
        $transferReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'transferReport' => $transferReport,
            'transferHeader' => $transferHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $transfer = $this->instantiate($id);

            $this->loadState($transfer);

            if (isset($_POST['ProductId'])) {
                $transfer->addDetail($_POST['ProductId']);
            }

            $this->renderPartial('_detail', array(
                'transfer' => $transfer,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $transfer = $this->instantiate($id);

            $this->loadState($transfer);

            $transfer->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'transfer' => $transfer,
                'error' => false,
            ));
        }
    }

    Public function actionAjaxHtmlUpdateAllProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $transfer = $this->instantiate($id);

            $this->loadState($transfer);

            $transfer->updateProducts();

            $this->renderPartial('_detail', array(
                'transfer' => $transfer,
                'error' => false,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $transfer = new Transfer(new TransferHeader(), array());
        else {
            $transferHeader = $this->loadModel($id);
            $transfer = new Transfer($transferHeader, $transferHeader->transferDetails(array('scopes' => 'resetScope')));
        }

        return $transfer;
    }

    public function loadModel($id) {
        $model = TransferHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($transfer) {
        if (isset($_POST['TransferHeader'])) {
            $transfer->header->attributes = $_POST['TransferHeader'];
        }
        if (isset($_POST['TransferDetail'])) {
            foreach ($_POST['TransferDetail'] as $item) {
                $detail = new TransferDetail();
                $detail->attributes = $item;
                $transfer->details[] = $detail;
            }
        }
        else
            $transfer->details = array();
    }

}

?>