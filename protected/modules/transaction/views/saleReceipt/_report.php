<?php
Yii::app()->clientScript->registerCss('_report', '
        .width1-1 { width: 25% }
        .width1-2 { width: 25% }
        .width1-3 { width: 25% }
        .width1-4 { width: 25% }
        
        .width2-1 { width: 33% }
        .width2-2 { width: 33% }
        .width2-3 { width: 33% }
		.width2-4 { width: 33% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Tanda Terima Penjualan Barang</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Tanda Terima Penjualan #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Customer</th>
		<th class="width1-4">Catatan</th>
	</tr>
	<tr id="header2">
		<td colspan="4">
			<table>
				<tr>
					<th class="width2-1">Invoice #</th>
					<th class="width2-2">Tanggal</th>
					<th class="width2-3">Order #</th>
					<th class="width2-4">Total</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($saleReceiptReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
			<td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="4">
				<table>
					<?php foreach ($header->saleReceiptDetails as $detail): ?>
						<tr>
							<td class="width2-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'invoice.number')); ?></td>
							<td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($detail, 'invoice.date')))); ?></td>
							<td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'invoice.orderHeader.number')); ?></td>
							<td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoice.totalDetail'))); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td class="width2-1" style="border-top: 1px solid"></td>
						<td class="width2-2" style="border-top: 1px solid"></td>
						<td class="width2-3" style="border-top: 1px solid; font-weight: bold; text-align: right">Total</td>
						<td class="width2-4" style="border-top: 1px solid; font-weight: bold; text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalDetail));  ?></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
</table>