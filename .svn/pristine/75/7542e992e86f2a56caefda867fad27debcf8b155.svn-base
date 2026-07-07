<?php
$this->breadcrumbs = array(
	'Product Discount Categories'=>array('create'),
	'Manage',
);

$this->menu = array(
	array('label'=>'Create Product Discount Category', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-discount-category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Discount Categories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-discount-category-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'columns'=>array(
		array(
			'name' => 'product_category_id',
			'filter' => CHtml::listData(ProductCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
			'value' => '$data->productCategory->name',
		),
		array(
			'name' => 'discount_category_id',
			'filter' => CHtml::listData(DiscountCategory::model()->findAll(), 'id', 'name'),
			'value' => '($data->discountCategory === null) ? "" : $data->discountCategory->name',
		),
		'value_1',
		'value_2',
		'value_3',
		'value_4',
		'value_5',
		'quotation_value',
		array(
			'name'=>'is_inactive',
			'filter' => array(ActiveRecord::ACTIVE=>'Active', ActiveRecord::INACTIVE=>'Inactive'),
			'value'=>'$data->status()',
		),
		/*
		'is_inactive',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view},{update}',
		),
	),
)); ?>
