<?php
$this->breadcrumbs = array(
	'Adjustment' => array('create'),
	'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php
	$this->widget('zii.widgets.CDetailView', array(
		'data' => $adjustmentHeader,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes' => array(
			array(
				'label' => 'Penyesuaian #',
				'value' => $adjustmentHeader->number,
			),
			array(
				'label' => 'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $adjustmentHeader->date),
			),
			array(
				'label' => 'Gudang',
				'value' => $warehouse->name,
			),
			array(
				'label' => 'Catatan',
				'value' => $adjustmentHeader->note,
			),
		),
	));
	?>

	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'adjustment-detail-grid',
		'dataProvider' => $detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns' => array(
			'product.name: Nama Barang',
			array(
				'header' => 'Jumlah Stok',
				'value' => 'number_format($data->quantity_current, 0)',
				'htmlOptions' => array(
					'style' => 'text-align: right',
				),
			),
			array(
				'header' => 'Jumlah Penyesuaian',
				'value' => 'number_format($data->quantity_adjustment, 0)',
				'htmlOptions' => array(
					'style' => 'text-align: right',
				),
			),
			'unit.name: Satuan',
		),
	));
	?>
	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
	</div>
	<br />
</div>
