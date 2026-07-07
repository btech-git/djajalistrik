<?php
$this->breadcrumbs = array(
	'Suppliers'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Supplier', 'url'=>array('create')),
	array('label'=>'Update Supplier', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Supplier', 'url'=>array('admin')),
);
?>


<h1>View Supplier #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'name',
		'company',
		'address',
		'city',
		'phone',
		'fax',
		'email',
		'website',
		'product_type',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
