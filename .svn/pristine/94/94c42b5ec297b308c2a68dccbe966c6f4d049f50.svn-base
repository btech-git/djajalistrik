<?php
$this->breadcrumbs = array(
	'Discount Categories'=>array('create'),
	'Manage',
);

$this->menu = array(
	array('label'=>'Create DiscountCategory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('discount-category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Discount Categories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target'=>'_blank', 'style' => 'display: none')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discount-category-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'selectionChanged'=>'js:function(id) {
		var url = "' . CController::createUrl('view') . '";
		$("#ViewLink").attr("href", url + "&id=" + $.fn.yiiGridView.getSelection(id));
		document.getElementById("ViewLink").click();
	}',
	'columns'=>array(
		'name',
		array(
			'name'=>'is_inactive',
			'filter' => array(ActiveRecord::ACTIVE=>'Active', ActiveRecord::INACTIVE=>'Inactive'),
			'value'=>'$data->status()',
		),
		array(
			'class'=>'CButtonColumn',
				'template'=>'{view},{update}',
		),
	),
)); ?>
