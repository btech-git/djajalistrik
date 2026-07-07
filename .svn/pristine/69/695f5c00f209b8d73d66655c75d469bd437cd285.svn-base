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
			'label'=>'Category',
			'name'=>'productCategory.name',
		),
		array(
			'label'=>'Brand',
			'name'=>'brand.name',
		),
		'type',
		'size',
		'volume',
		'color',
		array(
			'label'=>'Group',
			'name'=>'productGroup.name',
		),
		array(
			'label'=>'Selling Price',
			'value'=>number_format($model->price, 2),
		),
		'description',
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
