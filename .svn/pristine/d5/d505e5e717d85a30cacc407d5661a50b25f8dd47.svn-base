<?php
$this->breadcrumbs = array(
	'Product Groups'=>array('index'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create ProductGroup', 'url'=>array('create')),
	array('label'=>'View ProductGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductGroup', 'url'=>array('admin')),
);
?>

<h1>Update ProductGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>