<?php
$this->breadcrumbs = array(
	'Retur Penjualan'=>array('create'),
	'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$saleReturnHeader,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Retur #',
				'value'=>$saleReturnHeader->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $saleReturnHeader->date),
			),
			array(
				'label'=>'Gudang',
				'value'=>$warehouse->name,
			),
			array(
				'label'=>'Pemesanan #',
				'value'=>$orderHeader->number,
			),
			array(
				'label'=>'Nama Customer',
				'value'=>$orderHeader->customer->name,
			),
			array(
				'label'=>'Alamat',
				'value'=>$orderHeader->customer->address_1,
			),
			array(
				'label'=>'Catatan',
				'value'=>$saleReturnHeader->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'purchase-return-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
				'deliveryDetail.orderDetail.product_name: Nama Barang',
				array(
					'header'=>'Jumlah Retur',
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
					'header'=>'Total',
					'value'=>'number_format($data->total, 2)',
					'htmlOptions'=>array(
                        'style'=>'text-align: right',
					),
				),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'purchase-return-detail-grid',
		'dataProvider'=>$newProductsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
            'deliveryNewProduct.orderNewProduct.name: Nama Barang',
            array(
                'header'=>'Jumlah Retur',
                'value'=>'number_format($data->quantity, 0)',
                'htmlOptions'=>array(
                        'style'=>'text-align: right',
                ),
            ),
            'deliveryNewProduct.orderNewProduct.unit.name: Satuan',
            array(
                'header'=>'Harga Satuan',
                'value'=>'number_format($data->unit_price, 2)',
                'htmlOptions'=>array(
                    'style'=>'text-align: right',
                ),
            ),
			array(
                'header'=>'Total',
                'value'=>'number_format($data->total, 2)',
                'htmlOptions'=>array(
                    'style'=>'text-align: right',
                ),
            ),
		),
	)); ?>

	<br />

	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Update', array('update', 'id'=>$saleReturnHeader->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$saleReturnHeader->id), array('target'=>'_blank')); ?>
	</div>
</div>