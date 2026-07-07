<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 50% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT Djaja Listrik</div>
    <div style="font-size: larger">Laporan All Salesman Performance</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
<?php $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
<?php $startDate = $yearMonth . '-01'; ?>
<?php $endDate = $yearMonth . '-' . $daysInMonth; ?>

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Salesman</th>
            <th class="width1-3">Customer Total</th>
            <th class="width1-4">Invoice Total</th>
            <th class="width1-5">Jumlah Invoice (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php $customerQuantitySum = 0; ?>
        <?php $invoiceQuantitySum = 0; ?>
        <?php $grandTotalSum = '0.00'; ?>
        <?php foreach ($monthlySalesmanSaleReport as $i => $dataItem): ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['invoice_quantity']); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['invoice_total'])); ?></td>
            </tr>
            <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
            <?php $invoiceQuantitySum += $dataItem['invoice_quantity']; ?>
            <?php $grandTotalSum += $dataItem['invoice_total']; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
            <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($customerQuantitySum); ?></td>
            <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($invoiceQuantitySum); ?></td>
            <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
            </td>
        </tr>
    </tfoot>
</table>