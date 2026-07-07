<?php
Yii::app()->clientScript->registerCss('_report', '
        .width1-1 { width: 20% }
        .width1-2 { width: 20% }
        .width1-3 { width: 20% }
        .width1-4 { width: 20% }
		.width1-4 { width: 20% }
        
        .width2-1 { width: 33% }
        .width2-2 { width: 33% }
        .width2-3 { width: 33% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Transfer Barang Antar Gudang</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Transfer #</th>
		<th class="width1-2">Tanggal</th>
		<th class="width1-3">Gudang Asal</th>
		<th class="width1-4">Tujuan</th>
		<th class="width1-5">Catatan</th>
	</tr>
	<tr id="header2">
		<td colspan="5">
			<table>
				<tr>
					<th class="width2-1">Nama Barang</th>
					<th class="width2-2">Jumlah</th>
					<th class="width2-3">Satuan</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($transferReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
			<td class="width1-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
			<td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'warehouseIdFrom.name')); ?></td>
			<td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'warehouseIdTo.name')); ?></td>
			<td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="5">
				<table>
					<?php foreach ($header->transferDetails as $detail): ?>
						<tr>
							<td class="width2-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
							<td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
							<td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
						</tr>
					<?php endforeach; ?>
					
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
	
</table>