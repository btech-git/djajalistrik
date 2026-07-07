<?php
$this->breadcrumbs = array(
	'Product Categories'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage ProductCategory', 'url'=>array('admin')),
);
?>

<h1>Create ProductCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>