<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 65% }
	.width1-3 { width: 15% }

	.width2-1 { width: 15% }
	.width2-2 { width: 15% }
	.width2-3 { width: 25% }
	.width2-4 { width: 10% }
	.width2-5 { width: 10% }
	.width2-6 { width: 10% }
	.width2-7 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Pembelian Barang berdasarkan Produk</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Kategori</th>
		<th class="width1-2">Nama Produk</th>
		<th class="width1-3">Ukuran</th>
	</tr>
	<tr id="header2">
		<td colspan="3">
			<table>
				<tr>
				   <th class="width2-1">Pembelian #</th>
				   <th class="width2-2">Tanggal</th>
				   <th class="width2-7">Cabang</th>
				   <th class="width2-3">Supplier</th>
				   <th class="width2-4">Jumlah</th>
				   <th class="width2-5">Harga</th>
				   <th class="width2-6">Total</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($purchaseItemReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'productCategoryIdSingle.name')); ?></td>
			<td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
			<td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'size')); ?></td>
		</tr>
		<tr class="items2">
			<td colspan="3">
				<table>
					<?php $totalQuantityPurchase = 0; ?>
					<?php $totalPurchase = 0.00; ?>
					<?php foreach ($header->purchaseDetails as $detail): ?>
					<?php 
					if (
						CHtml::value($detail, 'purchaseHeader.is_approved') == 1 
						&& CHtml::value($detail, 'purchaseHeader.is_hold') == 0
						&& CHtml::value($detail, 'purchaseHeader.is_inactive') == 0
						&& CHtml::value($detail, 'purchaseHeader.date') >= $startDate): ?>
						<tr>
							<td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseHeader.number')); ?></td>
							<td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($detail, 'purchaseHeader.date')))); ?></td>
							<td class="width2-7"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseHeader.branch.name')); ?></td>	
							<td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseHeader.supplier.company')); ?></td>														
							<td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity = CHtml::value($detail, 'quantity'))); ?></td>
							<td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
							<td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total = CHtml::value($detail, 'total'))); ?></td>
						</tr>
						<?php $totalQuantityPurchase += $quantity; ?>
						<?php $totalPurchase += $total; ?>
					<?php endif;?>
					<?php endforeach; ?>
					<tr>
						<td class="width2-1" style="border-top: 1px solid"></td>
						<td class="width2-2" style="border-top: 1px solid"></td>
						<td class="width2-7" style="border-top: 1px solid"></td>
						<td class="width2-3" style="border-top: 1px solid; font-weight: bold; font-size: small">TOTAL</td>
						<td class="width2-4" style="border-top: 1px solid; font-weight: bold; text-align: right; font-size: small"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($totalQuantityPurchase))); ?></td>
						<td class="width2-5" style="border-top: 1px solid"></td>
						<td class="width2-6" style="border-top: 1px solid; font-weight: bold; text-align: right; font-size: small"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($totalPurchase))); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
</table>