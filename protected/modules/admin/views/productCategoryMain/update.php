<?php
$this->breadcrumbs = array(
	'Product Category Mains'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create ProductCategoryMain', 'url'=>array('create')),
	array('label'=>'View ProductCategoryMain', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductCategoryMain', 'url'=>array('admin')),
);
?>

<h1>Update ProductCategoryMain <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>