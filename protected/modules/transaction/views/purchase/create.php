<?php
$this->breadcrumbs = array(
	'Pembelian'=>array('admin'),
	'Create',
);

?>

<h1>Purchase Order</h1>

<?php echo $this->renderPartial('_form', array(
	'purchase'=>$purchase, 
	'product'=>$product, 
//	'orderHeader' => $orderHeader, 
	'supplier' => $supplier,
	'customer' => $customer,
	'productDataProvider' => $productDataProvider,
	'productCategoryMainId' => $productCategoryMainId,
//	'orderDataProvider' => $orderDataProvider,
	'error'=>$error,
	'orderHeader' => $orderHeader,
	'orderDataProvider' => $orderDataProvider,
	'customerName' => $customerName,
)); ?>