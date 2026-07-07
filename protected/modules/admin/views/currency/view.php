<?php
$this->breadcrumbs = array(
	'Currencys'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Currency', 'url'=>array('create')),
	array('label'=>'Update Currency', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Currency', 'url'=>array('admin')),
);
?>

<h1>View Currency #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/detailview/styles.css',
	'attributes'=>array(
		'id',
		'name',
		'rate',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
