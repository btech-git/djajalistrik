<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 50% }
	.width1-2 { width: 30% }
	.width1-3 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Stok Barang</div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Nama Produk</th>
        <th class="width1-2">Ukuran</th>
        <th class="width1-3">Stok</th>
    </tr>
    
    <tr id="header2">
        <td colspan="3"></td>
    </tr>
    
    <?php foreach ($stockLocalReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            <td class="width1-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'size')); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock($branchId))); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="3"></td>
        </tr>
    <?php endforeach; ?>
</table>