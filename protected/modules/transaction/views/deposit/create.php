<?php
$this->breadcrumbs = array(
	'Deposit'=>array('admin'),
	'Create',
);
?>

<h1>Penerimaan Kas</h1>

<?php echo $this->renderPartial('_form', array('deposit' => $deposit, 'error' => $error)); ?>
