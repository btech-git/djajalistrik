<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 16% }
	.width1-2 { width: 16% }
	.width1-3 { width: 16% }
	.width1-4 { width: 16% }
	.width1-5 { width: 16% }
	.width1-6 { width: 20% }


	.width2-1 { width: 35% }
	.width2-2 { width: 10% }
	.width2-3 { width: 15% }
	.width2-4 { width: 5% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
	.width2-7 { width: 5% }
	.width2-8 { width: 5% }
	.width2-9 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Order Salesman</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">S O #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Customer</th>
		<th class="width1-4">Kategori Pelanggan</th>
		<th class="width1-5">Salesman</th>
		<th class="width1-6">Grand Total</th>
	</tr>
	
	<tr id="header2">
		<td colspan="6">
	</tr>
	
	<?php foreach ($orderSalesmanReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
			<td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.discountCategory.name')); ?></td>
			<td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'customer.salesman.name')); ?></td>
			<td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grandTotal'))); ?></td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td class="width1-1" style="border-top: 1px solid"></td>
		<td class="width1-2" style="border-top: 1px solid"></td>
		<td class="width1-1" style="border-top: 1px solid"></td>
		<td class="width1-3" style="border-top: 1px solid"></td>
		<td class="width1-4" style="border-top: 1px solid; font-weight: bold; text-align: right">TOTAL PEMESANAN</td>
		<td class="width1-5" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($orderSalesmanReport, 'grandTotal')));  ?></td>
	</tr>
</table>