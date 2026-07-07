<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 70% }
	.width1-2 { width: 30% }

	.width2-1 { width: 20% }
	.width2-2 { width: 15% }
	.width2-3 { width: 25% }
	.width2-4 { width: 10% }
	.width2-5 { width: 15% }
	.width2-6 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Penjualan Barang berdasarkan Produk</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
		<th class="width1-1">Nama Produk</th>
		<th class="width1-2">Ukuran</th>
	</tr>
	<tr id="header2">
		<td colspan="2">
			<table>
				<tr>
                    <th class="width2-1">Penjualan #</th>
                    <th class="width2-2">Tanggal</th>
                    <th class="width2-3">Pelanggan</th>
                    <th class="width2-4">Jumlah</th>
                    <th class="width2-5">Harga Satuan</th>
                    <th class="width2-6">Total</th>
				</tr>
			</table>
		</td>
	</tr>
	<?php foreach ($saleItemReport->dataProvider->data as $header): ?>
		<tr class="items1">
			<td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
			<td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'size')); ?></td>
        </tr>
        
        <tr>
            <td colspan="2">
                <table>
					<?php $totalQuantitySale = 0; ?>
					<?php $totalSale = 0.00; ?>
					
					<?php foreach ($header->orderDetails as $detail): ?>
						<tr>
							<td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'id')); ?><?php echo CHtml::encode(CHtml::value($detail, 'orderHeader.number')); ?></td>
							<td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->orderHeader->date))); ?></td>
							<td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'orderHeader.customer.name')); ?></td>														
							<td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity = CHtml::value($detail, 'quantity_single'))); ?></td>
							<td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'priceAfterDiscount'))); ?></td>
							<td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total = CHtml::value($detail, 'total'))); ?></td>
						</tr>
						<?php $totalQuantitySale += $quantity; ?>
						<?php $totalSale += $total; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="3" style="border-top: 1px solid; font-weight: bold; font-size: small">TOTAL</td>
						<td class="width2-4" style="border-top: 1px solid; font-weight: bold; text-align: right; font-size: small"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($totalQuantitySale))); ?></td>
                        <td class="width2-5" style="border-top: 1px solid">&nbsp;</td>
						<td class="width2-6" style="border-top: 1px solid; font-weight: bold; text-align: right; font-size: small"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($totalSale))); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
</table>