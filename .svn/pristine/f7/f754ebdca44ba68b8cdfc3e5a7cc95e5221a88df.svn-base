<?php
$this->breadcrumbs=array(
	'Ouotation'=>array('/transaction/quotation/create'),
	'View',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$quotationHeader,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Pemesanan #',
				'value'=>$quotationHeader->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $quotationHeader->date),
			),
			array(
				'label'=>'Customer',
				'value'=>$customer->name,
			),
			array(
				'label'=>'Kategori Pelanggan',
				'value'=>$discountCategory->name,
			),
			array(
				'label'=>'Catatan',
				'value'=>$quotationHeader->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'quotation-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
			'product_name: Nama Barang',
			array(
				'header'=>'Jumlah',
				'value'=>'number_format($data->quantity, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			'unit.name: Satuan',
			array(
				'header'=>'Harga Satuan',
				'value'=>'number_format($data->unit_price, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'+/-(%) 1',
				'value'=>'number_format($data->discount_1, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'+/-(%) 2',
				'value'=>'number_format($data->discount_2, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'+/-(%) 3',
				'value'=>'number_format($data->discount_3, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'+/-(%) 4',
				'value'=>'number_format($data->discount_4, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'+/-(%) 5',
				'value'=>'number_format($data->discount_5, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'Quotation Value',
				'value'=>'number_format($data->quotation_value, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			 array(
				'header'=>'Total',
				'value'=>'number_format($data->total, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
		),
	)); ?>

	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Update', array('update', 'id'=>$quotationHeader->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$quotationHeader->id), array('target'=>'_blank')); ?>
	</div>
</div>