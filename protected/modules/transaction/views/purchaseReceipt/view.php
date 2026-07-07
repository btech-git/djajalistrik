<?php
$this->breadcrumbs = array(
    'Receipt' => array('create'),
    'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $purchaseReceipt,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'Penerimaan Faktur #',
                'value' => $purchaseReceipt->number,
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseReceipt->date),
            ),
            array(
                'label' => 'Supplier',
                'value' => $supplier->company,
            ),
            array(
                'label' => 'Branch',
                'value' => $purchaseReceipt->branch->name,
            ),
            array(
                'label' => 'Admin',
                'value' => $purchaseReceipt->admin->name,
            ),
            array(
                'label' => 'Catatan',
                'value' => $purchaseReceipt->note,
            ),
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-receipt-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'receiveHeader.purchaseHeader.number: Pembelian #',
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->receiveHeader->purchaseHeader->date)'
            ),
            'receiveHeader.purchaseHeader.orderHeader.reference_number: Order #',
            'invoice_number',
            'tax_number',
            array(
                'header' => 'Total',
                'value' => 'number_format($data->receiveHeader->grandTotal, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>
</div>

<div>
    <table style="width: 90%">
        <tr>
            <td style="width: 80%; text-align: right; font-weight: bold">Grand Total</td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseReceipt->totalDetail)); ?></td>
        </tr>
    </table>
</div>

<br />

<div id="link">
<?php echo CHtml::link('Create', array('create')); ?>
<?php echo CHtml::link('Update', array('update', 'id' => $purchaseReceipt->id)); ?>
<?php echo CHtml::link('Print', array('memo', 'id' => $purchaseReceipt->id), array('target' => '_blank')); ?>
</div>