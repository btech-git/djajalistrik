<?php
$this->breadcrumbs = array(
	'Product Category Mains'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create ProductCategoryMain', 'url'=>array('create')),
	array('label'=>'Update ProductCategoryMain', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage ProductCategoryMain', 'url'=>array('admin')),
);
?>

<h1>View ProductCategoryMain #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
