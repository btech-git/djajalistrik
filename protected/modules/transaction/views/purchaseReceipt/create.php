<?php
$this->breadcrumbs = array(
	'Receipt'=>array('admin'),
	'Create',
);
?>

<h1>Tanda Terima Pembelian</h1>

<?php echo $this->renderPartial('_form', array(
    'purchaseReceipt' => $purchaseReceipt, 
    'receiveHeader' => $receiveHeader,
    'supplier' => $supplier,
    'supplierDataProvider' => $supplierDataProvider,
    'supplierId' => $supplierId,
    'purchaseNumber' => $purchaseNumber,
    'dataProvider' => $dataProvider,
    'error'=>$error
)); ?>