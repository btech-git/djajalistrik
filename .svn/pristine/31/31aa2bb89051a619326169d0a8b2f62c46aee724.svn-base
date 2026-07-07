<?php
$this->breadcrumbs = array(
	'Brands'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Brand', 'url'=>array('create')),
	array('label'=>'Update Brand', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Brand', 'url'=>array('admin')),
);
?>

<h1>View Brand #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/detailview/styles.css',
	'attributes'=>array(
		'id',
		'name',
		'description',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
