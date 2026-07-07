<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
	.width1-5 { width: 20% }

	.width2-1 { width: 50% }
	.width2-2 { width: 15% }
	.width2-3 { width: 15% }
	.width2-4 { width: 20% }
	.width2-4 { width: 5% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
	.width2-7 { width: 5% }
	.width2-8 { width: 10% }
	.width2-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Purchase Order</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Pembelian #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Order</th>
		<th class="width1-4">Supplier</th>
		<th class="width1-5">Currency</th>
		<th class="width1-6">Catatan</th>
	</tr>
	<tr id="header2">
		<td colspan="6">
			<table>
				<tr>
					<th class="width2-1">Nama Barang</th>
					<th class="width2-2">Satuan</th>
					<th class="width2-3">Jumlah beli</th>
					<th class="width2-4">Harga Satuan</th>
					<th class="width2-5">+/- 1 (%)</th>
					<th class="width2-6">+/- 2 (%)</th>
					<th class="width2-7">+/- 3 (%)</th>
					<th class="width2-8">+/- 4 (%)</th>
					<th class="width2-9">+/- 5 (%)</th>
					<th class="width2-10">Total</th>
				</tr>
			</table>
			<table>
				<tr>
					<th class="width2-1">Nama Barang</th>
					<th class="width2-2">Kode</th>
					<th class="width2-3">Brand</th>
					<th class="width2-4">Jenis</th>
					<th class="width2-5">Jumlah</th>
					<th class="width2-6">Satuan</th>
					<th class="width2-7">Harga Satuan</th>
					<th class="width2-8">+/-(%) 1</th>
					<th class="width2-9">+/-(%) 2</th>
					<th class="width2-10">+/-(%) 3</th>
					<th class="width2-11">+/-(%) 4</th>
					<th class="width2-12">+/-(%) 5</th>
					<th class="width2-13">Total</th>
				</tr>
			</table>
		</td>
	</tr>
	<tr id="header3">
		<td colspan="10">
			
		</td>
	</tr>
	<?php foreach ($purchaseReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'orderHeader.number')); ?></td>
			<td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
			<td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'currency.name')); ?></td>
			<td class="width1-6" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="6">
				<table>
					<?php foreach ($header->purchaseDetails as $detail): ?>
						<tr>
							<td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
							<td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
							<td class="width2-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
							<td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
							<td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?></td>
							<td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?></td>
							<td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?></td>
							<td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?></td>
							<td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?></td>
							<td class="width2-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="9" style="border-top: 1px solid; font-weight: bold; text-align: right">Total</td>
						<td class="width2-10" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalDetail));  ?></td>
					</tr>
					
				</table>
				<table>
					<?php foreach ($header->purchaseNewProducts as $detail): ?>
						<tr>
							<td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
							<td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'product_code')); ?></td>
							<td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'product_type')); ?></td>
							<td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'brand.name')); ?></td>
							<td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
							<td class="width2-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
							<td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
							<td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?></td>
							<td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?></td>
							<td class="width2-10" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?></td>
							<td class="width2-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?></td>
							<td class="width2-12" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?></td>
							<td class="width2-13" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="12" style="border-top: 1px solid; font-weight: bold; text-align: right">Total</td>
						<td class="width2-13" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalNewProduct));  ?></td>
					</tr>
				</table>
				<table>
					<tr>
						<td style="text-align: right">PPN <?php echo ((int)$header->is_tax === 0) ? 10 : 0; ?>%: </td>
						<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalTax)); ?></td>
					</tr>
					<tr>
						<td style="text-align: right">TOTAL P0</td>
						<td style="text-align: right; width: 20%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grandTotal')));  ?></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="5" style="border-top: 1px solid; font-weight: bold; text-align: right">TOTAL PEMBELIAN</td>
		<td class="width1-6" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseReport, 'grandTotal')));  ?></td>
	</tr>
</table>