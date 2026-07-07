<?php
$this->breadcrumbs = array(
	'saleReceipt'=>array('admin'),
	'Create',
);
?>

<h1>Revisi Tanda Terima Penjualan</h1>

<?php echo $this->renderPartial('_form', array(
	'saleReceipt' => $saleReceipt,
	'invoice' => $invoice, 
	'customer' => $customer, 
	'dataProvider' => $dataProvider,
	'error'=>$error
)); ?>