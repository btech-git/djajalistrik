<?php
$this->breadcrumbs = array(
	'Sale Payment'=>array('admin'),
	'Create',
);
?>

<h1>Pembayaran Penjualan Barang</h1>

<?php echo $this->renderPartial('_form', array(
    'salePayment' => $salePayment, 
    'invoiceHeader' => $invoiceHeader,
    'dataProvider' => $dataProvider,
    'customer' => $customer,
)); ?>

