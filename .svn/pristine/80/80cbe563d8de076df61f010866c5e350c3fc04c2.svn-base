<?php

class InvoiceTemporaryController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxJsonOrder' || $filterChain->action->id === 'ajaxJsonSupplier' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxHtmlAddOrder' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('invoiceCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('invoiceEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('invoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new InvoiceTemporary;

        if (isset($_POST['InvoiceTemporary'])) {
            $model->attributes = $_POST['InvoiceTemporary'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['InvoiceTemporary'])) {
            $model->attributes = $_POST['InvoiceTemporary'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('InvoiceTemporary');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new InvoiceTemporary('search');
        $model->unsetAttributes();
        if (isset($_GET['InvoiceTemporary']))
            $model->attributes = $_GET['InvoiceTemporary'];

        $dataProvider = $model->search();
        $dataProvider->sort->defaultOrder = 'date ASC, customer.name ASC';
        $dataProvider->criteria->with = array('customer');

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('invoiceEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['InvoiceMemoAllowed']) && Yii::app()->session['InvoiceMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('InvoiceMemoAllowed');
        
        $invoice = $this->loadModel($id);

        $this->render('memo', array(
            'invoice' => $invoice,
        ));
    }

    public function loadModel($id) {
        $model = InvoiceTemporary::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
