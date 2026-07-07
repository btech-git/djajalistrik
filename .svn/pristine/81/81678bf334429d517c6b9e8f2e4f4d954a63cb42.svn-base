<?php
$this->breadcrumbs = array(
	'Salesmen'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Salesman', 'url'=>array('create')),
	array('label'=>'View Salesman', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Salesman', 'url'=>array('admin')),
);
?>

<h1>Update Salesman <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>