<?php
$this->breadcrumbs = array(
	'Product Discount Categories'=>array('admin'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Create Product Discount Category', 'url'=>array('create')),
	array('label'=>'Update Product Discount Category', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Product Discount Category', 'url'=>array('admin')),
);
?>


<h1>View Product Discount Category #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'value_1',
		'value_2',
		'value_3',
		'value_4',
		'value_5',
		'quotation_value',
		array(
			'label'=>'Discount Category',
			'name'=>'discountCategory.name',
		),
		array(
			'label'=>'Category',
			'name'=>'productCategory.name',
		),
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
