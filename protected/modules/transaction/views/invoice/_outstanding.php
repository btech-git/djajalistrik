<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 5% }
    .width1-4 { width: 20% }
    .width1-5 { width: 8% }
    .width1-6 { width: 6% }
    .width1-7 { width: 5% }
    .width1-8 { width: 8% }
    .width1-9 { width: 8% }
    .width1-10 { width: 8% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Djaja Listrik</div>
    <div style="font-size: larger">Outstanding Invoice</div>
</div>

<br />

<table style="border: 1px solid">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Invoice #</th>
            <th class="width1-7">Branch</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">TOP (hari)</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">PO Customer #</th>
            <th class="width1-6">F Pajak #</th>
            <th class="width1-8">Total (Rp)</th>
            <th class="width1-9">Bayar (Rp)</th>
            <th class="width1-10">Sisa (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::link($header->number, array("view", "id"=>$header->id), array('target' => '_blank')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'branch.code')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($header, 'date'))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.payment_term')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5">
                    <?php echo CHtml::link(CHtml::value($header, 'orderHeader.reference_number'), array("view", "id"=>$header->id), array('target' => '_blank')); ?>
                </td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'tax_number')); ?></td>
                <td class="width1-8" style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($header, 'grand_total')), 2); ?></td>
                <td class="width1-9" style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($header, 'total_payment')), 2); ?></td>
                <td class="width1-10" style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($header, 'remaining')), 2); ?></td>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>