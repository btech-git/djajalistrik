<?php
$this->breadcrumbs = array(
	'Branches'=>array('create'),
	'Manage',
);

$this->menu = array(
	array('label'=>'Create Branch', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('branch-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Branches</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'branch-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/gridview/styles.css',
	'columns'=>array(
		'name',
		'tax_number',
		'phone',
		array(
			'name'=>'is_inactive',
			'filter' => array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL,
            ),
			'value'=>'$data->status()',
		),
		array(
			'class'=>'CButtonColumn',
				'template'=>'{view}{update}',
		),
	),
)); ?>
