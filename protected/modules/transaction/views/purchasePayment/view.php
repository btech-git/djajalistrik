<?php
$this->breadcrumbs = array(
	'Purchase Payment'=>array('create'),
	'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$purchasePayment,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Penerimaan #',
				'value'=>$purchasePayment->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $purchasePayment->date),
			),
			array(
				'label'=>'Pembelian TT #',
				'value'=>$purchaseReceiptHeader->number,
			),
			array(
				'label'=>'Tanggal Pembelian',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseReceiptHeader->date),
			),
			array(
				'label'=>'Total Pembelian',
				'value'=>number_format($purchaseReceiptHeader->totalDetail, 2),
			),
			array(
				'label'=>'Catatan',
				'value'=>$purchasePayment->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'purchase-payment-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
			'paymentType.name: Jenis Pembayaran',
			array(
				'header'=>'Jumlah',
				'value'=>'number_format($data->amount, 2)',
				'htmlOptions'=>array(
						'style'=>'text-align: right',
				),
			),
			'memo',
		),
	)); ?>

	<br />

	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Update', array('update', 'id'=>$purchasePayment->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$purchasePayment->id), array('target'=>'_blank')); ?>
	</div>
</div>