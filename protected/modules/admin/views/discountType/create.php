<?php
$this->breadcrumbs = array(
	'Discount Types'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage DiscountType', 'url'=>array('admin')),
);
?>

<h1>Create DiscountType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>