<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 16% }
	.width1-3 { width: 16% }
	.width1-4 { width: 16% }

	.width2-1 { width: 20% }
	.width2-2 { width: 20% }
	.width2-3 { width: 20% }
	.width2-4 { width: 20% }
	.width2-5 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Penyesuaian Stok Barang</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Penyesuaian #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Gudang</th>
		<th class="width1-4">Catatan</th>
	</tr>
	<tr id="header2">
		<td colspan="4">
			<table>
				<tr>
					<th class="width2-1">Nama Barang</th>
					<th class="width2-2">Sekarang</th>
					<th class="width2-3">Penyesuaian</th>
					<th class="width2-4">Perbedaan</th>
					<th class="width2-5">Satuan</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($adjustmentReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
			<td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="4">
				<table>
					<?php foreach ($header->adjustmentDetails as $detail): ?>
						<tr>
							<td class="width2-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
							<td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity_current')); ?></td>
							<td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity_adjustment')); ?></td>
							<td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_adjustment') - CHtml::value($detail, 'quantity_current'))); ?></td>
							<td class="width2-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
</table>