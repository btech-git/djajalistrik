<?php
$this->breadcrumbs = array(
	'Product Discount Categories'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage Product Discount Category', 'url'=>array('admin')),
);
?>

<h1>Create Product Discount Category</h1>

<?php echo $this->renderPartial('_form', array('productDiscountCategories'=>$productDiscountCategories)); ?>