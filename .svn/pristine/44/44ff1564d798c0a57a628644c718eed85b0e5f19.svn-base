<?php
$this->breadcrumbs = array(
	'Accounts'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'Update Account', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h1>View Account #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'name',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
