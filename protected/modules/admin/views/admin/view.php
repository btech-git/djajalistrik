<?php
$this->breadcrumbs = array(
	'Admins'=>array('admin'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Create Admin', 'url'=>array('create')),
	array('label'=>'Update Admin', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Admin', 'url'=>array('admin')),
);
?>

<h1>View Admin #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'username',
		'phone',
		'email',
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
