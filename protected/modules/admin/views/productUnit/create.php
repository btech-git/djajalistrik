<?php
$this->breadcrumbs = array(
	'Product Units'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage Product Unit', 'url'=>array('admin')),
);
?>

<h1>Create Product Unit</h1>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'dataProvider' => $dataProvider,
	'product' => $product,
)); ?>