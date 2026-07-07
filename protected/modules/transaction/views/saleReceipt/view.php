<?php
$this->breadcrumbs = array(
    'Tanda Terima Penjualan' => array('customerList'),
    'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $saleReceipt,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'Tanda Terima Penjualan #',
                'value' => $saleReceipt->number,
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleReceipt->date),
            ),
            array(
                'label' => 'Tanggal Kirim',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleReceipt->delivery_date),
            ),
            array(
                'label' => 'Customer',
                'value' => $customer->name,
            ),
            array(
                'label' => 'Branch',
                'value' => $saleReceipt->branch->name,
            ),
            array(
                'label' => 'Alamat Kirim',
                'value' => $saleReceipt->delivery_address,
            ),
            array(
                'label' => 'Catatan',
                'value' => $saleReceipt->note,
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sale-receipt-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'invoiceHeader.number: Invoice #',
            'invoiceHeader.tax_number: F. Pajak #',
            'invoiceHeader.orderHeader.reference_number: PO #',
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->invoiceHeader->date)'
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->invoice_amount, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    ));
    ?>

    <br />

    <div id="link">
        <?php echo CHtml::link('Create', array('customerList')); ?>
        <?php echo CHtml::link('Update', array('update', 'id' => $saleReceipt->id)); ?>
        <?php echo CHtml::link('Print', array('memo', 'id' => $saleReceipt->id), array('target' => '_blank')); ?>
    </div>
</div>
