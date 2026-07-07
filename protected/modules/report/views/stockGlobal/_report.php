<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 50% }
	.width1-2 { width: 20% }
	.width1-3 { width: 15% }
	.width1-4 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Stok Barang Global</div>
</div>

<br />

<table class="report">
    <tr id="header1">
<!--		<th class="width1-1">Kategori</th>-->
        <th class="width1-1">Nama Produk</th>
        <th class="width1-2">Ukuran</th>
        <th class="width1-3">Stok</th>
        <th class="width1-4">HPP</th>
    </tr>
    <tr id="header2">
        <td colspan="4"></td>
    </tr>
    <?php foreach ($stockGlobalReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            <td class="width1-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'size')); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($header->getCurrentStock($endDate)))); ?></td>
            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getCostOfGoodsSold($endDate)));  ?></td>
        </tr>
        <tr class="items2">
            <td colspan="4"></td>
        </tr>
    <?php endforeach; ?>
</table>