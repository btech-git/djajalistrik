<?php
$this->breadcrumbs = array(
	'Order'=>array('admin'),
	'Create',
);
?>

<h1>Revisi Sales Order</h1>

<?php echo $this->renderPartial('_form', array(
	'order' => $order,
	'dataProvider' => $dataProvider,
	'productCategoryMainId' => $productCategoryMainId,
	'product' => $product, 
	'customer' => $customer,
	'error'=>$error,
)); ?>