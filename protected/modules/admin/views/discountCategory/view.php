<?php
$this->breadcrumbs = array(
	'Discount Categories'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create DiscountCategory', 'url'=>array('create')),
	array('label'=>'Update DiscountCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage DiscountCategory', 'url'=>array('admin')),
);
?>

<h1>View DiscountCategory #<?php echo $model->id; ?></h1>

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
