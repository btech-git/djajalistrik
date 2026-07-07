<?php
$this->breadcrumbs = array(
	'Invoice'=>array('admin'),
	'Create',
);
?>

<h1>Invoice Penjualan</h1>

<?php echo $this->renderPartial('_form', array(
	'invoice' => $invoice, 
    'orderHeader' => $orderHeader,
    'deliveryDetail' => $deliveryDetail,
    'deliveryDetailDataProvider' => $deliveryDetailDataProvider,
    'deliveryNewProduct' => $deliveryNewProduct,
    'deliveryNewProductDataProvider' => $deliveryNewProductDataProvider,
)); ?>