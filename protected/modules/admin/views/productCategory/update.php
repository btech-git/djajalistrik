<?php
$this->breadcrumbs = array(
	'Product Categories'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create ProductCategory', 'url'=>array('create')),
	array('label'=>'View ProductCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductCategory', 'url'=>array('admin')),
);
?>

<h1>Update ProductCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>