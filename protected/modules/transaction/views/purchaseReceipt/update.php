<?php
$this->breadcrumbs = array(
    'Receipt'=>array('admin'),
    'Create',
);
?>

<h1>Revisi Tanda Terima Pembelian</h1>

<?php echo $this->renderPartial('_form', array(
    'purchaseReceipt' => $purchaseReceipt, 
    'receiveHeader' => $receiveHeader,
    'dataProvider' => $dataProvider,
    'supplier' => $supplier,
    'supplierDataProvider' => $supplierDataProvider,
    'supplierId' => $supplierId,
    'purchaseNumber' => $purchaseNumber,
    'error'=>$error
)); ?>