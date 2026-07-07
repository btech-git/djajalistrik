<?php
$this->breadcrumbs = array(
	'Invoice Temporaries'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('invoice-temporary-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Invoice</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<div id="link">
	<?php echo CHtml::link('Create', array('create')); ?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-temporary-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'selectionChanged'=>'js:function(id) {
		window.location.href = "' . CController::createUrl('view', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id);
	}',
	'columns'=>array(
		'number: No. Bon',
		array(
			'header' => 'Tanggal Bon',
			'name' => 'date',
			'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
		),
		array(
			'header' => 'Nama Perusahaan',
			'name' => 'customer_id',
			'filter' => CHtml::listData(Customer::model()->findAll(), 'id', 'name'),
			'value' => '$data->customer->name',
		),
		array(
			'header'=>'Total Bon',
			'value'=>'number_format($data->amount, 2)',
			'htmlOptions'=>array(
				'style'=>'text-align: right',
			),
		),
		array(
			'header' => 'Tanggal T T',
			'name' => 'date_receipt',
			'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date_receipt)'
		),
		'note',
		'return',
		array(
			'header'=>'Jumlah Pembayaran',
			'value'=>'number_format($data->amount_paid, 2)',
			'htmlOptions'=>array(
				'style'=>'text-align: right',
			),
		),
		array(
			'header' => 'Tanggal Bayar',
			'name' => 'date_payment',
			'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date_payment)'
		),
		array(
			'header' => 'Metode Pembayaran',
			'name' => 'payment_type_id',
			'filter' => CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'),
			'value' => '($data->paymentType === null) ? "N/A" : $data->paymentType->name',
		),
		array(
			'header' => 'Status',
			'name'=>'is_paid',
			'filter' => array(InvoiceTemporary::UNPAID=>InvoiceTemporary::UNPAID_LITERAL, InvoiceTemporary::PAID=>InvoiceTemporary::PAID_LITERAL),
			'value'=>'$data->paymentStatus()',
		),
		array(
			'class' => 'CButtonColumn',
			'template' => $buttonTemplate,
		),
	),
)); ?>
