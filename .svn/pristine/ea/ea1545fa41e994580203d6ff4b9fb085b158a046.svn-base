<?php
$this->breadcrumbs = array(
	'Product Units'=>array('create'),
	'Manage',
);

$this->menu = array(
	array('label'=>'Create Product Unit', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-unit-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Units</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-unit-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'columns'=>array(
		array(
			'name' => 'product_id',
			'filter' => CHtml::listData(Product::model()->findAll(), 'id', 'name'),
			'value' => '($data->product === null) ? "" : $data->product->name',
		),
		array(
			'name' => 'product_group_id',
			'filter' => CHtml::listData(ProductGroup::model()->findAll(), 'id', 'name'),
			'value' => '($data->productGroup === null) ? "" : $data->productGroup->name',
		),
		array(
			'name' => 'product_category_id',
			'filter' => CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'),
			'value' => '($data->productCategory === null) ? "" : $data->productCategory->name',
		),
		array(
			'name' => 'unit_id',
			'filter' => CHtml::listData(Unit::model()->findAll(), 'id', 'name'),
			'value' => '($data->unit === null) ? "" : $data->unit->name',
		),
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
