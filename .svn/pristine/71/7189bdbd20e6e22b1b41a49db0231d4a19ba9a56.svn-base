<?php
$this->breadcrumbs = array(
	'Products'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>View Product #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'code',
		'name',
		array(
			'label'=>'Brand',
			'name'=>'brand.name',
		),
		'type',
		'size',
		'color',
		'description',
		'quantity_bulk',
		'quantity_minimum',
		'selling_price',		
		array(
			'label'=>'Product Category Bulk',
			'name'=>'productCategoryIdBulk.name',
		),
		array(
			'label'=>'Product Category Single',
			'name'=>'productCategoryIdSingle.name',
		),
		array(
			'label'=>'Unit Bulk',
			'name'=>'unitIdBulk.name',
		),
		array(
			'label'=>'Unit Single',
			'name'=>'unitIdSingle.name',
		),
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
