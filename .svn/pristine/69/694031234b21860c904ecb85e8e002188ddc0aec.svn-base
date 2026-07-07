<?php
$this->breadcrumbs = array(
    'Invoice Temporaries' => array('create'),
    $model->id,
);
?>

<h1>View Invoice #<?php echo $model->id; ?></h1>

<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            'number',
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
            ),
            array(
                'label' => 'Jumlah (Rp)',
                'value' => number_format($model->amount, 2),
            ),
            array(
                'label' => 'Tanggal Penerimaan',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date_receipt),
            ),
            'note',
            'return',
            array(
                'label' => 'Jumlah (Rp)',
                'value' => number_format($model->amount_paid, 2),
            ),
            array(
                'label' => 'Tanggal Pembayaran',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date_payment),
            ),
            array(
                'label' => 'Customer',
                'value' => $model->customer->name,
            ),
            array(
                'label' => 'Tipe Pembayaran',
                'value' => ($model->paymentType === null) ? 'N/A' : $model->paymentType->name,
            ),
            array(
                'label' => 'Status Pembayaran',
                'value' => $model->paymentStatus(),
            ),
        ),
    )); ?>
    
    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('Update', array('update', 'id' => $model->id)); ?>
        <?php echo CHtml::link('Print', array('memo', 'id' => $model->id), array('target' => '_blank')); ?>
        <?php echo CHtml::link('Print Faktur Pajak', array('taxform', 'id' => $model->id), array('target' => '_blank')); ?>
    </div>
</div>
