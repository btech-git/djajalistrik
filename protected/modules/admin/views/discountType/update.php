<?php
$this->breadcrumbs = array(
	'Discount Types'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create DiscountType', 'url'=>array('create')),
	array('label'=>'View DiscountType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DiscountType', 'url'=>array('admin')),
);
?>

<h1>Update DiscountType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>