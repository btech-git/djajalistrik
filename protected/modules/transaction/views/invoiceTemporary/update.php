<?php
$this->breadcrumbs = array(
	'Invoice Temporaries'=>array('admin'),
	$model->id=>array('view', 'id'=>$model->id),
	'Update',
);
?>

<h1>Update Invoice<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>