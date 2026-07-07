<?php
$this->breadcrumbs = array(
	'Discount Types'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create DiscountType', 'url'=>array('create')),
	array('label'=>'Update DiscountType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage DiscountType', 'url'=>array('admin')),
);
?>

<h1>View DiscountType #<?php echo $model->id; ?></h1>

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
