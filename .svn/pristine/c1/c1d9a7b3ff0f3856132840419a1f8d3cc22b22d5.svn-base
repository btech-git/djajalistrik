<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 10% }
	.width1-4 { width: 10% }
	.width1-5 { width: 10% }
	.width1-6 { width: 10% }
	.width1-7 { width: 10% }
	.width1-8 { width: 10% }
	.width1-9 { width: 10% }
	.width1-10 { width: 10% }
    ');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Stok Barang Global</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Nama Produk</th>
        <th class="width1-2">Ukuran</th>
        <th class="width1-3">Stok Awal</th>
        <th class="width1-4">Nilai Awal</th>
        <th class="width1-5">Stok Masuk</th>
        <th class="width1-6">Nilai Masuk</th>
        <th class="width1-7">Stok Keluar</th>
        <th class="width1-8">Nilai Keluar</th>
        <th class="width1-9">Stok Akhir</th>
        <th class="width1-10">Nilai Akhir</th>
    </tr>
    
    <tr id="header2">
        <td colspan="10"></td>
    </tr>
    
    <?php foreach ($stockReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            <td class="width1-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'size')); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getStockBeginning($startDate))); ?></td>
            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getCogsBeginning($startDate)));  ?></td>
            <td class="width1-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getStockIn($startDate, $endDate))); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getCogsIn($startDate, $endDate)));  ?></td>
            <td class="width1-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getStockOut($startDate, $endDate))); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getCogsOut($startDate, $endDate)));  ?></td>
            <td class="width1-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getStockEnding($endDate))); ?></td>
            <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getCostOfGoodsSold($endDate)));  ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="10"></td>
        </tr>
    <?php endforeach; ?>
        
    <tr>
        <td class="width1-3" style="font-weight: bold">TOTAL</td>
        <td class="width1-4" style="font-weight: bold; text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportStockBeginning($stockReport, $startDate))); ?></td>
        <td class="width1-5" style="font-weight: bold; text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportStockIn($stockReport, $startDate, $endDate))); ?></td>
        <td class="width1-6" style="font-weight: bold; text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportStockOut($stockReport, $startDate, $endDate))); ?></td>
        <td class="width1-7" style="font-weight: bold; text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportStockEnding($stockReport, $endDate))); ?></td>
    </tr>
</table>