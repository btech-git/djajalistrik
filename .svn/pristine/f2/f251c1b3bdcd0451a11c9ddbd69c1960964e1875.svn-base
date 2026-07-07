<?php
$this->breadcrumbs = array(
    'Penerimaan' => array('create'),
    'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $receiveHeader,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'Penerimaan #',
                'value' => $receiveHeader->number,
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->date),
            ),
            array(
                'label' => 'Referensi',
                'value' => $receiveHeader->reference,
            ),
            array(
                'label' => 'Gudang',
                'value' => $warehouse->name,
            ),
            array(
                'label' => 'Pembelian #',
                'value' => $purchaseHeader->number,
            ),
            array(
                'label' => 'Order #',
                'value' => ($purchaseHeader->orderHeader === null) ? '' : $purchaseHeader->orderHeader->number,
            ),
            array(
                'label' => 'Catatan',
                'value' => $receiveHeader->note,
            ),
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receive-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'product.name: Nama Barang',
            array(
                'header' => 'Jumlah Terima',
                'value' => 'number_format($data->quantity_receive, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Jumlah Retur',
                'value' => 'number_format($data->quantity_return, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'unit.name: Satuan',
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receive-new-product-grid',
        'dataProvider' => $newProductsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'purchaseNewProduct.product_name: Nama Barang',
            array(
                'header' => 'Jumlah Terima',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Jumlah Retur',
                'value' => 'number_format($data->quantity_return, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'purchaseNewProduct.unit.name: Satuan',
        ),
    )); ?>

    <br />

    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('Update', array('update', 'id' => $receiveHeader->id)); ?>
        <?php echo CHtml::link('Print', array('memo', 'id' => $receiveHeader->id), array('target' => '_blank')); ?>
    </div>
</div>