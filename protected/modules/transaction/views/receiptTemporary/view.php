<?php
$this->breadcrumbs = array(
	'Purchase Receipt'=>array('create'),
	'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$receiptTemporary,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Penerimaan Faktur #',
				'value'=>$receiptTemporary->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $receiptTemporary->date),
			),
			array(
				'label'=>'Customer',
				'value'=>$customer->name,
			),
			array(
				'label' => 'Jumlah Bayar (Rp)',
				'value' => number_format($receiptTemporary->amount, 2),
			),
			array(
				'label'=>'Jenis Pembayaran',
				'value'=>$receiptTemporary->paymentMethod(),
			),
			array(
				'label'=>'Giro #',
				'value'=>$receiptTemporary->cheque_number,
			),
			array(
				'label'=>'Status Barang',
				'value'=>$receiptTemporary->itemReady(),
			),
			array(
				'label'=>'Status Pengiriman',
				'value'=>$receiptTemporary->deliveryReady(),
			),
			array(
				'label'=>'Catatan',
				'value'=>$receiptTemporary->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'purchase-receipt-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
			'invoiceTemporary.number: Invoice #',
			array(
				'header' => 'Tanggal',
				'name' => 'date',
				'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->invoiceTemporary->date)'
			),
			array(
				'header'=>'Jumlah',
				'value'=>'number_format($data->invoiceTemporary->amount, 2)',
				'htmlOptions'=>array(
						'style'=>'text-align: right',
				),
			),
			array(
				'header' => 'Tanggal TT',
				'name' => 'date',
				'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->invoiceTemporary->date)'
			),
			array(
				'header'=>'Jumlah Lunas',
				'value'=>'number_format($data->invoiceTemporary->amount_paid, 2)',
				'htmlOptions'=>array(
						'style'=>'text-align: right',
				),
			),
		),
	)); ?>

	<br />

	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Update', array('update', 'id'=>$receiptTemporary->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$receiptTemporary->id), array('target'=>'_blank')); ?>
	</div>
</div>