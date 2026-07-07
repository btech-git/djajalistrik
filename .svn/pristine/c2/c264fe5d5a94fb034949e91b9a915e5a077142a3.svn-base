<?php
$this->breadcrumbs = array(
	'Product Categories'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create ProductCategory', 'url'=>array('create')),
	array('label'=>'Update ProductCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage ProductCategory', 'url'=>array('admin')),
);
?>

<h1>View ProductCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'name',
		array(
			'label'=>'Product Category Main',
			'name'=>'productCategoryMain.name',
		),
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
