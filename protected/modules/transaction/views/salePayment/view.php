<?php
$this->breadcrumbs = array(
    'Sale Payment' => array('customerList'),
    'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $salePayment,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'Pelunasan #',
                'value' => $salePayment->number,
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date),
            ),
            array(
                'label' => 'Customer',
                'value' => $salePayment->customer->company,
            ),
            array(
                'label' => 'Catatan',
                'value' => $salePayment->note,
            ),
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sale-payment-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            array(
                'header' => 'Invoice #',
                'value' => '$data->invoiceHeader->number',
            ),
            'paymentType.name: Jenis Pembayaran',
            'memo',
            array(
                'header' => 'Total Invoice',
                'value' => 'number_format($data->total_invoice, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Jumlah Bayar',
                'value' => 'number_format($data->amount, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Biaya Lainnya',
                'value' => 'number_format($data->additional_amount, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>

    <br />

    <table>
        <tr>
            <td style="width: 80%; font-weight: bold; text-align: right">Total Invoice</td>
            <td style="font-weight: bold; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'totalInvoice'))); ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: right">Total Payment</td>
            <td style="font-weight: bold; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'totalDetail'))); ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: right">Sisa</td>
            <td style="font-weight: bold; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'remaining'))); ?>
            </td>
        </tr>
    </table>
    <div id="link">
<?php echo CHtml::link('Create', array('customerList')); ?>
<?php echo CHtml::link('Update', array('update', 'id' => $salePayment->id)); ?>
<?php echo CHtml::link('Print', array('memo', 'id' => $salePayment->id), array('target' => '_blank')); ?>
    </div>
</div>