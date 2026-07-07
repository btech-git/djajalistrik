<?php
$this->breadcrumbs = array(
	'Discount Categories'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage DiscountCategory', 'url'=>array('admin')),
);
?>

<h1>Create DiscountCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>