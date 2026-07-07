<?php
Yii::app()->clientScript->registerCss('_report', '
        .width1-1 { width: 16% }
        .width1-2 { width: 16% }
        .width1-3 { width: 16% }
        .width1-4 { width: 16% }
        
        .width2-1 { width: 40% }
        .width2-2 { width: 10% }
        .width2-3 { width: 10% }
		.width2-4 { width: 10% }
        .width2-5 { width: 15% }
		.width2-6 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Retur Penjualan Barang</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Retur #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Order #</th>
		<th class="width1-4">Gudang</th>
		<th class="width1-5">Catatan</th>
	</tr>
	<tr id="header2">
		<td colspan="5">
			<table>
				<tr>
					<th class="width2-1">Nama Barang</th>
					<th class="width2-2">Jumlah Retur</th>
					<th class="width2-3">Satuan</th>
					<th class="width2-4">Harga Satuan</th>
					<th class="width2-5">Total</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($saleReturnReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'orderHeader.number')); ?></td>
			<td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
			<td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="5">
				<table>
					<?php foreach ($header->saleReturnDetails as $detail): ?>
						<tr>
							<td class="width2-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.product_name')); ?></td>
<!--							<td class="width2-2" style="text-align: center"><?php //echo CHtml::encode(CHtml::value($detail, 'quantityOrdered')); ?></td>-->
							<td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
							<td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
							<td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'orderDetail.unit_price_single'))); ?></td>
							<td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td class="width1-1" style="border-top: 1px solid"></td>
						<td class="width1-2" style="border-top: 1px solid"></td>
						<td class="width1-3" style="border-top: 1px solid; font-weight: bold; text-align: center">TOTAL RETUR</td>
						<td class="width1-4" style="border-top: 1px solid"></td>
						<td class="width1-5" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grandTotal')));  ?></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td class="width1-1" style="border-top: 1px solid"></td>
		<td class="width1-2" style="border-top: 1px solid"></td>
		<td class="width1-3" style="border-top: 1px solid"></td>
		<td class="width1-4" style="border-top: 1px solid; font-weight: bold; text-align: center">TOTAL RETUR</td>
		<td class="width1-5" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReturnReport, 'grandTotal')));  ?></td>
	</tr>
</table>