<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
	.width1-5 { width: 20% }


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
	<div style="font-size: larger">Laporan Quotation</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Quotation #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Customer</th>
		<th class="width1-4">Kategori Customer</th>
		<th class="width1-5">Catatan</th>
	</tr>
	<tr id="header2">
		<td colspan="5">
			<table>
				<tr>
					<th class="width2-1">Nama Barang</th>
					<th class="width2-2">Quantity</th>
					<th class="width2-3">Satuan</th>
					<th class="width2-4">Harga Satuan</th>
					<th class="width2-5">+/- (%)</th>
					<th class="width2-6">+/- 2 (%)</th>
					<th class="width2-7">+/- 3 (%)</th>
					<th class="width2-8">+/- 4 (%)</th>
					<th class="width2-9">+/- 5 (%)</th>
					<th class="width2-10">Quotation Value</th>
					<th class="width2-11">Total</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($quotationReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
			<td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.discountCategory.name')); ?></td>
			<td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="5">
				<table>
					<?php foreach ($header->quotationDetails as $detail): ?>
						<tr>
							<td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
							<td class="width2-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
							<td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
							<td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
							<td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?></td>
							<td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?></td>
							<td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?></td>
							<td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?></td>
							<td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?></td>
							<td class="width2-10" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quotation_value'))); ?></td>
							<td class="width2-11" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td class="width2-1" style="border-top: 1px solid"></td>
						<td class="width2-2" style="border-top: 1px solid"></td>
						<td class="width2-3" style="border-top: 1px solid"></td>
						<td class="width2-4" style="border-top: 1px solid"></td>
						<td class="width2-5" style="border-top: 1px solid"></td>
						<td class="width2-6" style="border-top: 1px solid"></td>
						<td class="width2-7" style="border-top: 1px solid"></td>
						<td class="width2-8" style="border-top: 1px solid"></td>
						<td class="width2-9" style="border-top: 1px solid"></td>
						<td class="width2-10" style="border-top: 1px solid; font-weight: bold; text-align: center">Total</td>
						<td class="width2-11" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->subTotal));  ?></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td class="width1-2" style="border-top: 1px solid"></td>
		<td class="width1-3" style="border-top: 1px solid"></td>
		<td class="width1-4" style="border-top: 1px solid"></td>
		<td class="width1-5" style="border-top: 1px solid; font-weight: bold; text-align: right">TOTAL QUOTATION</td>
		<td class="width1-6" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotationReport, 'grandTotal')));  ?></td>
	</tr>
</table>