<?php

class BranchController extends CrudController {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'view') {
            if (!Yii::app()->user->checkAccess('administrator'))
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
        $model = new Branch;

        if (isset($_POST['Branch'])) {
            $model->attributes = $_POST['Branch'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if ($model->save()) {
                $this->saveImageFile($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Branch'])) {
            $model->attributes = $_POST['Branch'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if ($model->save()){
                $this->saveImageFile($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionAdmin() {
        $model = new Branch('search');
        $model->unsetAttributes();
        if (isset($_GET['Branch']))
            $model->attributes = $_GET['Branch'];

        $dataProvider = $model->search();
        $dataProvider->model->resetScope();

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function saveImageFile($model) {
        if ($model->file) {
            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/' . $model->file->name;
            $model->file->saveAs($originalPath);

            require_once( dirname(Yii::app()->request->scriptFile) . '/protected/extensions/phpthumb/ThumbLib.inc.php' );

//            $image = PhpThumbFactory::create($originalPath);
//            $image->resize(500, 500)->save($originalPath);
        }
    }

    public function loadModel($id) {
        $model = Branch::model()->findByPk($id, array('scopes' => 'resetScope'));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
