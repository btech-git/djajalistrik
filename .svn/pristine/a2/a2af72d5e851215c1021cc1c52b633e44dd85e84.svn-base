<?php
$this->breadcrumbs = array(
	'Product Groups'=>array('index'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create ProductGroup', 'url'=>array('create')),
	array('label'=>'Update ProductGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage ProductGroup', 'url'=>array('admin')),
);
?>

<h1>View ProductGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/detailview/styles.css',
	'attributes'=>array(
		'id',
		'name',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
