<?php
$this->breadcrumbs = array(
	'Salesmen'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Salesman', 'url'=>array('create')),
	array('label'=>'Update Salesman', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Salesman', 'url'=>array('admin')),
);
?>

<h1>View Salesman #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/detailview/styles.css',
	'attributes'=>array(
		'id',
		'name',
		'address',
		'phone',
		'email',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
