<?php

class AdjustmentController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'view' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'updateAllProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail') {
            if (!(Yii::app()->user->checkAccess('adjustmentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('adjustmentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $adjustment = $this->instantiate(null);
        $adjustment->header->number = CodeNumber::make($adjustment->header, 'number', 'ADJ', Yii::app()->user);
        $adjustment->header->admin_id = Yii::app()->user->id;
        $adjustment->header->branch_id = Yii::app()->user->branch_id;

        $productCategoryMainId = isset($_GET['ProductCategoryMainId']) ? $_GET['ProductCategoryMainId'] : '';
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $dataProvider = $product->search();
        $dataProvider->criteria->with = array(
            'productCategoryIdSingle' => array(
                'with' => array(
                    'productCategoryMain'
                ),
            ),
        );
        $dataProvider->criteria->compare('productCategoryMain.id', $productCategoryMainId);

        $dataProvider->criteria->order = 't.id DESC';

        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($adjustment);
            if ($adjustment->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $adjustment->header->id));
            else
                $error = true;
        }

        $this->render('create', array(
            'adjustment' => $adjustment,
            'dataProvider' => $dataProvider,
            'productCategoryMainId' => $productCategoryMainId,
            'product' => $product,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $adjustmentHeader = $this->loadModel($id);

        $warehouse = $adjustmentHeader->warehouse(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('adjustment_header_id', $adjustmentHeader->id);
        $detailsDataProvider = new CActiveDataProvider('AdjustmentDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'product:resetScope',
            'unit:resetScope'
        );

        $this->render('view', array(
            'adjustmentHeader' => $adjustmentHeader,
            'warehouse' => $warehouse,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionAdmin() {
        $adjustmentHeader = Search::bind(new AdjustmentHeader('search'), isset($_GET['AdjustmentHeader']) ? $_GET['AdjustmentHeader'] : array());
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $adjustmentHeaderDate = (isset($_GET['AdjustmentHeaderDate'])) ? $_GET['AdjustmentHeaderDate'] : '';

        $dataProvider = $adjustmentHeader->search();
        $dataProvider->criteria->with = array(
            'warehouse',
            'branch',
            'admin',
        );

        if (!empty($adjustmentHeaderDate)) {
            $dataProvider->criteria->addCondition('t.date = :date');
            $dataProvider->criteria->params[':date'] = $adjustmentHeaderDate;
        }

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('deliveryEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'adjustmentHeader' => $adjustmentHeader,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionReport() {
        $adjustmentHeader = Search::bind(new AdjustmentHeader('search'), isset($_GET['AdjustmentHeader']) ? $_GET['AdjustmentHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $adjustmentReport = new AdjustmentReport($adjustmentHeader->search());
        $adjustmentReport->setupLoading();
        $adjustmentReport->setupPaging($pageSize, $currentPage);
        $adjustmentReport->setupSorting();
        $adjustmentReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'adjustmentReport' => $adjustmentReport,
            'adjustmentHeader' => $adjustmentHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);

            $this->loadState($adjustment);

            if (isset($_POST['ProductId'])) {
                $adjustment->addDetail($_POST['ProductId']);
            }

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);

            $this->loadState($adjustment);

            $adjustment->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlUpdateAllProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);

            $this->loadState($adjustment);

            $adjustment->updateProducts();

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonDifference($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);

            $this->loadState($adjustment);

            $object = array(
                'quantityDifference' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $adjustment->details[$index]->getQuantityDifference($_POST['AdjustmentHeader']['warehouse_id']))),
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $adjustment = new Adjustment(new AdjustmentHeader(), array());
        else {
            $adjustmentHeader = $this->loadModel($id);
            $adjustment = new Adjustment($adjustmentHeader, $adjustmentHeader->adjustmentDetails(array('scopes' => 'resetScope')));
        }

        return $adjustment;
    }

    public function loadModel($id) {
        $model = AdjustmentHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($adjustment) {
        if (isset($_POST['AdjustmentHeader'])) {
            $adjustment->header->attributes = $_POST['AdjustmentHeader'];
        }
        if (isset($_POST['AdjustmentDetail'])) {
            foreach ($_POST['AdjustmentDetail'] as $i => $item) {
                $detail = new AdjustmentDetail();
                $detail->attributes = $item;
                $adjustment->details[] = $detail;
            }
        }
        else
            $adjustment->details = array();
    }

}

?>