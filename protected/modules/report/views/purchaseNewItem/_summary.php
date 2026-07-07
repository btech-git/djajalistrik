<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 15% }
	.width1-3 { width: 10% }
	.width1-4 { width: 20% }
	.width1-5 { width: 5% }
	.width1-6 { width: 10% }
	.width1-7 { width: 5% }
	.width1-8 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
	<div style="font-size: larger">PT. DJAJA LISTRIK</div>
	<div style="font-size: larger">Laporan Pembelian Barang berdasarkan Produk Baru</div>
	<div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
	<tr id="header1">
        <th class="width1-1">Nama Produk</th>
        <th class="width1-2">Pembelian #</th>
        <th class="width1-3">Tanggal</th>
        <th class="width1-4">Supplier</th>
        <th class="width1-5">Quantity</th>
        <th class="width1-6">Harga</th>
        <th class="width1-7">+/-(%)</th>
        <th class="width1-8">Total</th>
	</tr>
    
	<tr id="header2">
		<td colspan="8"></td>
	</tr>
    
	<?php foreach ($purchaseNewItemSummary->dataProvider->data as $header): ?>
        <?php if ($header->purchaseHeader !=null) : ?> 
            <tr class="items1">
                <td class="width1-1" style="text-align: center;"><?php echo CHtml::encode(CHtml::value($header, 'product_name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($header->purchaseHeader->number); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchaseHeader->date))); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header->purchaseHeader, 'customer.name')); ?></td>														
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'quantity'))); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'unit_price'))); ?></td>
                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'discountNominal'))); ?></td>
                <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total'))); ?></td>
            </tr>
            
            <tr class="items2">
                <td colspan="8"></td>
            </tr>
		
        <?php endif; ?>
    <?php endforeach; ?>
</table>