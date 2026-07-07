<?php
$this->breadcrumbs = array(
	'Transfer'=>array('create'),
	'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$transferHeader,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Transfer #',
				'value'=>$transferHeader->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $transferHeader->date),
			),
			array(
				'label'=>'Gudang Asal',
				'value'=>$warehouseIdFrom->name,
			),
			array(
				'label'=>'Gudang Tujuan',
				'value'=>$warehouseIdTo ->name,
			),
			array(
				'label'=>'Catatan',
				'value'=>$transferHeader->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'transfer-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
				'product.name: Nama Barang',
				array(
					'header'=>'Jumlah',
					'value'=>'number_format($data->quantity, 0)',
					'htmlOptions'=>array(
							'style'=>'text-align: right',
					),
				),
				'unit.name: Satuan',
		),
	)); ?>

	<br />

	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Print Transfer', array('memo', 'id'=>$transferHeader->id), array('target'=>'_blank')); ?>
	</div>
</div>