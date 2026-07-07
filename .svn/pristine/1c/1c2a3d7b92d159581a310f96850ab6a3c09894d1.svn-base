<?php
$this->breadcrumbs = array(
	'Product Units'=>array('admin'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Create Product Unit', 'url'=>array('create')),
	array('label'=>'Update Product Unit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Product Unit', 'url'=>array('admin')),
);
?>

<h1>View Product Unit #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'volume',
		array(
			'label'=>'Selling Price',
			'value'=>number_format($model->selling_price, 2),
		),
		'quantity_minimum',
		array(
			'label'=>'Product',
			'name'=>'product.name',
		),
		array(
			'label'=>'Group',
			'name'=>'productGroup.name',
		),
		array(
			'label'=>'Category',
			'name'=>'productCategory.name',
		),
		array(
			'label'=>'Unit',
			'name'=>'unit.name',
		),
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
