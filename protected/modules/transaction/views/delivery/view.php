<?php
$this->breadcrumbs = array(
    'Delivery' => array('/transaction/delivery/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $deliveryHeader,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'Pengiriman #',
                'value' => $deliveryHeader->number,
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $deliveryHeader->date),
            ),
            array(
                'label' => 'Order #',
                'value' => $orderHeader->reference_number,
            ),
            array(
                'label' => 'Customer',
                'value' => $orderHeader->customer->company,
            ),
            array(
                'label' => 'Gudang',
                'value' => $warehouse->name,
            ),
            'note',
            'note_internal',
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'delivery-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'orderDetail.product_name: Nama Barang',
            array(
                'header' => 'Jumlah Kirim',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'unit.name: Satuan'
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'delivery-detail-grid',
        'dataProvider' => $newProductsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'orderNewProduct.name: Nama Barang',
            array(
                'header' => 'Jumlah Kirim',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    ));
    ?>
    <div id="link">
        <?php echo CHtml::link('Create', array('orderList')); ?>
        <?php echo CHtml::link('Update', array('update', 'id' => $deliveryHeader->id)); ?>
        <?php echo CHtml::link('Print', array('memo', 'id' => $deliveryHeader->id), array('target' => '_blank')); ?>
    </div>
</div>