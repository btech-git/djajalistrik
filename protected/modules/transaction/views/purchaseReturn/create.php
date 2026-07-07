<?php
$this->breadcrumbs = array(
	'PurchaseReturn'=>array('admin'),
	'Create',
);
?>

<h1>Retur Pembelian Barang</h1>

<?php echo $this->renderPartial('_form', array(
	'purchaseReturn'=> $purchaseReturn, 
	'receiveHeader' => $receiveHeader, 
    'supplierId' => $supplierId,
    'purchaseNumber' => $purchaseNumber,
	'dataProvider' => $dataProvider,
	'error'=>$error,
)); ?>
