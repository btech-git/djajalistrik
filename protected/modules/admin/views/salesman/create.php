<?php
$this->breadcrumbs = array(
	'Salesmen'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage Salesman', 'url'=>array('admin')),
);
?>

<h1>Create Salesman</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>