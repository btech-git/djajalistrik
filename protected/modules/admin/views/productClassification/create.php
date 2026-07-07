<?php
$this->breadcrumbs = array(
	'Product Classifications'=>array('index'),
	'Create',
);

$this->menu = array(
	array('label'=>'List ProductClassification', 'url'=>array('index')),
	array('label'=>'Manage ProductClassification', 'url'=>array('admin')),
);
?>

<h1>Create ProductClassification</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>