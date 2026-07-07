<?php
$this->breadcrumbs = array(
	'Product Classifications'=>array('index'),
	$model->name,
);

$this->menu = array(
	array('label'=>'List ProductClassification', 'url'=>array('index')),
	array('label'=>'Create ProductClassification', 'url'=>array('create')),
	array('label'=>'Update ProductClassification', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductClassification', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete', 'id'=>$model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductClassification', 'url'=>array('admin')),
);
?>

<h1>View ProductClassification #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'is_inactive',
	),
)); ?>
