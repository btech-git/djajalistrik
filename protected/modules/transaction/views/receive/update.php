<?php
$this->breadcrumbs = array(
	'Receive'=>array('admin'),
	'Create',
);
?>

<h1>Revisi Penerimaan Barang</h1>

<?php echo $this->renderPartial('_form', array(
	'receive'=>$receive, 
	'purchase'=>$purchase, 
	'dataProvider' => $dataProvider,
	'error'=>$error
)); ?>