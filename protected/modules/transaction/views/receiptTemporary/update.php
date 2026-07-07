<?php
$this->breadcrumbs = array(
	'Receipt'=>array('admin'),
	'Create',
);
?>

<h1>Revisi Faktur Tagihan Penjualan</h1>

<?php echo $this->renderPartial('_form', array(
	'receiptTemporary' => $receiptTemporary,
	'invoiceTemporary' => $invoiceTemporary,
	'customer' => $customer,
	'dataProvider' => $dataProvider,
	'error' => $error,
)); ?>