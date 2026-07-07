<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 15% }
	.width1-4 { width: 10% }
	.width1-5 { width: 10% }
	.width1-6 { width: 10% }
	.width1-7 { width: 10% }
	.width1-8 { width: 10% }
	.width1-9 { width: 10% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Faktur Pajak Masukan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">TT Pembelian #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Supplier</th>
        <th class="width1-4">Branch</th>
        <th class="width1-5">Invoice #</th>
        <th class="width1-6">F. Pajak</th>
        <th class="width1-7">DPP</th>
        <th class="width1-8">PPN</th>
        <th class="width1-9">Total</th>
    </tr>
    
    <tr id="header2">
        <td colspan="9"></td>
    </tr>
    
    <?php $total = 0.00; $totalTax = 0.00; $totalDpp = 0.00;?>
    <?php foreach ($purchaseTaxReport->dataProvider->data as $header): ?>
        <?php 
        $subTotal = $header->receiveHeader->subTotal;
        $taxAmount = $header->receiveHeader->totalTax;
        $grandTotal = CHtml::value($header, 'amount'); 
        ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.number')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchaseReceiptHeader->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.supplier.name')); ?></td>
            <td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.branch.name')); ?></td>
            <td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
            <td class="width1-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'tax_number')); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subTotal)); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxAmount)); ?></td>
            <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?></td>
        </tr>
        <?php $total += $grandTotal; $totalTax += $taxAmount; $totalDpp += $subTotal; ?>
    <?php endforeach; ?>
        
    <tr class="items2">
        <td colspan="6" style="text-align: right; font-weight: bold; border-top: 1px solid">TOTAL</td>
        <td style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDpp)); ?></td>
        <td style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalTax)); ?></td>
        <td style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $total)); ?></td>
    </tr>
</table>