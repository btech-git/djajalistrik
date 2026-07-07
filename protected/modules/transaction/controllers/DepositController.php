<?php

class DepositController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'ajaxHtmlAddPayment' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('depositCreate') || Yii::app()->user->checkAccess('depositEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('depositEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('depositReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $deposit = $this->instantiate(null);
        $deposit->header->number = CodeNumber::make($deposit->header, 'number', 'DPS', Yii::app()->user);
        $deposit->header->admin_id = Yii::app()->user->id;
        $deposit->header->branch_id = Yii::app()->user->branch_id;

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($deposit);
            if ($deposit->save(Yii::app()->db)) {
                Yii::app()->session['DepositMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $deposit->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'deposit' => $deposit,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $deposit = $this->instantiate($id);

        $deposit->header->admin_id = Yii::app()->user->id;

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($deposit);
            if ($deposit->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $deposit->header->id));
            else
                $error = true;
        }
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }
        $this->render('update', array(
            'deposit' => $deposit,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $deposit = $this->loadModel($id);

        $account = $deposit->account(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('deposit_header_id', $deposit->id);
        $detailsDataProvider = new CActiveDataProvider('DepositDetail', array(
                    'criteria' => $criteria,
                ));

        $this->render('view', array(
            'deposit' => $deposit,
            'account' => $account,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['DepositMemoAllowed']) && Yii::app()->session['DepositMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('DepositMemoAllowed');

        $deposit = $this->loadModel($id);

        $account = $deposit->account(array('scopes' => 'resetScope'));
        $branch = $deposit->branch(array('scopes' => 'resetScope'));

        $depositDetails = $deposit->depositDetails;

        $this->render('memo', array(
            'account' => $account,
            'branch' => $branch,
            'deposit' => $deposit,
            'depositDetails' => $depositDetails,
        ));
    }

    public function actionAdmin() {
        $deposit = Search::bind(new DepositHeader('search'), isset($_GET['DepositHeader']) ? $_GET['DepositHeader'] : array());
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;

        $dataProvider = $deposit->search();
        $dataProvider->criteria->with = array(
            'account:resetScope',
            'branch:resetScope',
        );

        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('depositEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'deposit' => $deposit,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $depositHeader = $this->loadModel($id);
            
            if ($depositHeader !== null) {
                $depositHeader->is_inactive = !$depositHeader->is_inactive;
                $depositHeader->update(array('is_inactive'));
                
                foreach ($depositHeader->depositDetails as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $detail->update(array('is_inactive'));
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddPayment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $deposit = $this->instantiate($id);

            $this->loadState($deposit);

            $deposit->addDetail();

            $this->renderPartial('_detail', array(
                'deposit' => $deposit,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $deposit = $this->instantiate($id);

            $this->loadState($deposit);

            $deposit->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'deposit' => $deposit,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $deposit = $this->instantiate($id);

            $this->loadState($deposit);

            $object = array(
                'amount' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($deposit->details[$index], 'amount')),
                'total' => Yii::app()->numberFormatter->format('#,##0.00', $deposit->total),
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $deposit = new Deposit(new DepositHeader(), array());
        else {
            $depositHeader = $this->loadModel($id);
            $deposit = new Deposit($depositHeader, $depositHeader->depositDetails);
        }

        return $deposit;
    }

    public function loadModel($id) {
        $model = DepositHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($deposit) {
        if (isset($_POST['DepositHeader'])) {
            $deposit->header->attributes = $_POST['DepositHeader'];
        }
        if (isset($_POST['DepositDetail'])) {
            foreach ($_POST['DepositDetail'] as $i => $item) {
                if (isset($deposit->details[$i]))
                    $deposit->details[$i]->attributes = $item;
                else {
                    $detail = new DepositDetail();
                    $detail->attributes = $item;
                    $deposit->details[] = $detail;
                }
            }
            if (count($_POST['DepositDetail']) < count($deposit->details))
                array_splice($deposit->details, $i + 1);
        }
        else
            $deposit->details = array();
    }

}