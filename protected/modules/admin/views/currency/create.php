<?php
$this->breadcrumbs = array(
	'Currencys'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage Currency', 'url'=>array('admin')),
);
?>

<h1>Create Currency</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>