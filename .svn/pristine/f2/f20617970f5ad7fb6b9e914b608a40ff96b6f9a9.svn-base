<?php
$this->breadcrumbs = array(
	'Products'=>array('create'),
	'Manage',
);

$this->menu = array(
	array('label'=>'Create Product', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Products</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target'=>'_blank', 'style' => 'display: none')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'selectionChanged'=>'js:function(id) {
		var url = "' . CController::createUrl('view') . '";
		$("#ViewLink").attr("href", url + "&id=" + $.fn.yiiGridView.getSelection(id));
		document.getElementById("ViewLink").click();
	}',
	'selectionChanged'=>'js:function(id) {
		window.location.href = "' . CController::createUrl('view', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id);
	}',
	'columns'=>array(
		'code',
		'name',
		array(
			'name' => 'brand_id',
			'filter' => CHtml::listData(Brand::model()->findAll(), 'id', 'name'),	
			'value' => '($data->brand === null) ? "" : $data->brand->name',
		),
		array(
			'header' => 'Total',
			'value' => 'number_format($data->selling_price, 2)',
			'htmlOptions'=>array(
				'style'=>'text-align: right',
			),
		),
		array(
			'header' => 'Kategori',
			'name' => 'product_category_id_single',
			'filter' => CHtml::listData(ProductCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),	
			'value' => '($data->productCategoryIdSingle === null) ? "" : $data->productCategoryIdSingle->name',
		),
		array(
			'header' => 'Satuan Single',
			'name' => 'unit_id_single',
			'filter' => CHtml::listData(Unit::model()->findAll(), 'id', 'name'),	
			'value' => '($data->unitIdSingle === null) ? "" : $data->unitIdSingle->name',
		),
		array(
			'header' => 'Satuan Bulk',
			'name' => 'unit_id_bulk',
			'filter' => CHtml::listData(Unit::model()->findAll(), 'id', 'name'),	
			'value' => '($data->unitIdBulk === null) ? "" : $data->unitIdBulk->name',
		),
		array(
			'header' => 'Status',
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
