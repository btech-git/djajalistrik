<?php
CHtml::refresh(300);

$this->breadcrumbs = array(
	'Quotation'=>array('create'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Kelola Data Quotation</h1>
<div id="detail_div">
	<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
	</p>
	
	<div id="link">
		<?php echo CHtml::link('Create', array('create'), array('target'=>'_blank')); ?>
	</div>

	<div style="overflow: auto">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'quotation-grid',
			'dataProvider'=>$dataProvider,
			'filter'=>$quotation,
			'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
			'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
			'selectionChanged'=>'js:function(id) {
				window.location.href = "' . CController::createUrl('view', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id);
			}',
			'columns'=>array(
				'number',
				 array(
					'header' => 'Tanggal',
					'name' => 'date',
					'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
				),
				array(
					'name' => 'customer_id',
					'filter' => CHtml::listData(Customer::model()->findAll(), 'id', 'name'),
					'value' => '$data->customer->name',
				),
				array(
					'class'=>'CButtonColumn',
					'template' => $buttonTemplate,
				),
			),
		)); ?>
	</div>
</div>
