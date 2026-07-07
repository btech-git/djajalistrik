<?php
$this->breadcrumbs = array(
	'Retur Pembelian'=>array('create'),
	'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$purchaseReturnHeader,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Retur #',
				'value'=>$purchaseReturnHeader->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseReturnHeader->date),
			),
			array(
				'label'=>'Supplier',
				'value'=>$purchaseHeader->supplier->name,
			),
			array(
				'label'=>'Perusahaan',
				'value'=>$purchaseHeader->supplier->company,
			),
			array(
				'label'=>'Alamat',
				'value'=>$purchaseHeader->supplier->address,
			),
			array(
				'label'=>'Penerimaan #',
				'value'=>$receiveHeader->number,
			),
			array(
				'label'=>'Gudang',
				'value'=>$warehouse->name,
			),
			array(
				'label'=>'Catatan',
				'value'=>$purchaseReturnHeader->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'purchase-return-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
			'product.name: Nama Barang',
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
				'value'=>'number_format($data->receiveDetail->purchaseDetail->unit_price, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'header'=>'Total',
				'value'=>'number_format($data->getTotal($data->purchaseReturnHeader->receive_header_id), 2)',
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
			'receiveNewProduct.purchaseNewProduct.product_name: Nama Barang',
			array(
				'header'=>'Jumlah Retur',
				'value'=>'number_format($data->quantity, 0)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'header'=>'Harga Satuan',
				'value'=>'number_format($data->receiveNewProduct->purchaseNewProduct->unit_price, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'header'=>'Total',
				'value'=>'number_format($data->getTotal($data->purchaseReturnHeader->receive_header_id), 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
		),
	)); ?>

	<br />

    <div>
        <table>
            <tr style="background-color: #F5DEB3">
                <td style="text-align: right; font-weight: bold; width: 80%">Grand Total:</td>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($grandTotal = $purchaseReturnHeader->getGrandTotal($purchaseReturnHeader->receive_header_id)) > 1000000 ? round($grandTotal, -3) : round($grandTotal, -2))); ?>
                </td>
            </tr>
        </table>
    </div>

    <br />
    
	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Update', array('update', 'id'=>$purchaseReturnHeader->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$purchaseReturnHeader->id), array('target'=>'_blank')); ?>
	</div>
</div>
