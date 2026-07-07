<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 10% }
	.width1-4 { width: 10% }
	.width1-5 { width: 10% }
	.width1-6 { width: 10% }
	.width1-7 { width: 10% }
	.width1-8 { width: 10% }
	.width1-9 { width: 10% }
	.width1-10 { width: 10% }
	.width1-11 { width: 10% }
	.width1-12 { width: 10% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Sales Order Outstanding</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Order #</th>
        <th class="width1-2">Branch</th>
        <th class="width1-3">Tanggal</th>
        <th class="width1-4">Customer</th>
        <th class="width1-5">PO Customer #</th>
        <th class="width1-6">Note Internal</th>
        <th class="width1-7">PO #</th>
        <th class="width1-8">Pengiriman #</th>
        <th class="width1-9">Invoice #</th>
        <th class="width1-10">User</th>
        <th class="width1-11">Total Order (Rp)</th>
        <th class="width1-12">Total Invoice (Rp)</th>
    </tr>
    <tr id="header2">
        <td colspan="12">&nbsp;</td>
    </tr>
    <?php $totalInvoice = '0.00'; ?> 
    <?php $totalOrder = '0.00'; ?>
    <?php foreach ($dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'branch.code')); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'reference_number')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'note_internal')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'purchaseNumber')); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'deliveryNumber')); ?></td>
            <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'invoiceNumber')); ?></td>
            <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
            <td class="width1-11" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grandTotal'))); ?>
            </td>
            <td class="width1-12" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'totalInvoice'))); ?>
            </td>
        </tr>
        <?php $totalInvoice += CHtml::value($header, 'totalInvoice'); ?>
        <?php $totalOrder += CHtml::value($header, 'grandTotal'); ?>
    <?php endforeach; ?>
        
    <tr>
        <td colspan="10" style="border-top: 1px solid; font-weight: bold; text-align: right">TOTAL</td>
        <td class="width1-11" style="border-top: 1px solid; font-weight: bold; text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalOrder)); ?>
        </td>
        <td class="width1-12" style="border-top: 1px solid; font-weight: bold; text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoice)); ?>
        </td>
    </tr>
</table>