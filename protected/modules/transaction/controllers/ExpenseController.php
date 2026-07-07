<?php

class ExpenseController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'ajaxHtmlAddPayment' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('expenseCreate') || Yii::app()->user->checkAccess('expenseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('expenseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('expenseReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $expense = $this->instantiate(null);

        $expense->header->number = CodeNumber::make($expense->header, 'number', 'EXP', Yii::app()->user);
        $expense->header->admin_id = Yii::app()->user->id;
        $expense->header->branch_id = Yii::app()->user->branch_id;

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($expense);
            if ($expense->save(Yii::app()->db)) {
                Yii::app()->session['ExpenseMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $expense->header->id));
            }
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'expense' => $expense,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $expense = $this->instantiate($id);

        $expense->header->admin_id = Yii::app()->user->id;

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($expense);
            if ($expense->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $expense->header->id));
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'expense' => $expense,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $expense = $this->loadModel($id);

        $account = $expense->account(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('expense_header_id', $expense->id);
        $detailsDataProvider = new CActiveDataProvider('ExpenseDetail', array(
                    'criteria' => $criteria,
                ));

        $this->render('view', array(
            'expense' => $expense,
            'account' => $account,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['ExpenseMemoAllowed']) && Yii::app()->session['ExpenseMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('ExpenseMemoAllowed');

        $expense = $this->loadModel($id);

        $account = $expense->account(array('scopes' => 'resetScope'));
        $branch = $expense->branch(array('scopes' => 'resetScope'));

        $expenseDetails = $expense->expenseDetails;

        $this->render('memo', array(
            'account' => $account,
            'branch' => $branch,
            'expense' => $expense,
            'expenseDetails' => $expenseDetails,
        ));
    }

    public function actionAdmin() {
        $expense = Search::bind(new ExpenseHeader('search'), isset($_GET['ExpenseHeader']) ? $_GET['ExpenseHeader'] : array());
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;

        $dataProvider = $expense->search();
        $dataProvider->criteria->with = array(
            'account:resetScope',
            'branch:resetScope',
        );
        $dataProvider->criteria->order = 't.id DESC';
        $dataProvider->pagination->pageSize = $pageSize;
        

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('expenseEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'expense' => $expense,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $expenseHeader = $this->loadModel($id);
            
            if ($expenseHeader !== null) {
                $expenseHeader->is_inactive = !$expenseHeader->is_inactive;
                $expenseHeader->update(array('is_inactive'));
                
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
            $expense = $this->instantiate($id);

            $this->loadState($expense);

            $expense->addDetail();

            $this->renderPartial('_detail', array(
                'expense' => $expense,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $expense = $this->instantiate($id);

            $this->loadState($expense);

            $expense->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'expense' => $expense,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $expense = $this->instantiate($id);

            $this->loadState($expense);

            $object = array(
                'amount' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($expense->details[$index], 'amount')),
                'total' => Yii::app()->numberFormatter->format('#,##0.00', $expense->total),
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $expense = new Expense(new ExpenseHeader(), array());
        else {
            $expenseHeader = $this->loadModel($id);
            $expense = new Expense($expenseHeader, $expenseHeader->expenseDetails);
        }

        return $expense;
    }

    public function loadModel($id) {
        $model = ExpenseHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($expense) {
        if (isset($_POST['ExpenseHeader'])) {
            $expense->header->attributes = $_POST['ExpenseHeader'];
        }
        if (isset($_POST['ExpenseDetail'])) {
            foreach ($_POST['ExpenseDetail'] as $i => $item) {
                if (isset($expense->details[$i]))
                    $expense->details[$i]->attributes = $item;
                else {
                    $detail = new ExpenseDetail();
                    $detail->attributes = $item;
                    $expense->details[] = $detail;
                }
            }
            if (count($_POST['ExpenseDetail']) < count($expense->details))
                array_splice($expense->details, $i + 1);
        }
        else
            $expense->details = array();
    }

}