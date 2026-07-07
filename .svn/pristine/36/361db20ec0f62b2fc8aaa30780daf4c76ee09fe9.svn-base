<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 15% }
	.width1-2 { width: 15% }
	.width1-3 { width: 15% }
	.width1-4 { width: 15% }
	.width1-5 { width: 20% }
	.width1-6 { width: 20% }

	.width2-1 { width: 20% }
	.width2-2 { width: 15% }
	.width2-3 { width: 65% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Pembayaran Pembelian Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Pembayaran #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Tanda Terima #</th>
        <th class="width1-4">Supplier</th>
        <th class="width1-5">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="5">
            <table>
                <tr>
                    <th class="width2-1">Jenis Pembayaran</th>
                    <th class="width2-2">Jumlah</th>
                    <th class="width2-3">Memo</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($purchasePaymentReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.number')); ?></td>
            <td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.supplier.name')); ?></td>
            <td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="5">
                <table>
                    <?php $amountSum = '0.00'; ?>
                    <?php foreach ($header->purchaseReceiptHeader->purchaseReceiptDetails as $receiptDetail): ?>
                        <?php $amount = CHtml::value($receiptDetail, 'amount'); ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($receiptDetail, 'receiveHeader.purchaseHeader.number')); ?></td>
                            <td class="width2-1">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiptDetail->receiveHeader->purchaseHeader->date))); ?>
                            </td>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($receiptDetail, 'invoice_number')); ?></td>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($receiptDetail, 'tax_number')); ?></td>
                            <td class="width2-2" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amount)); ?>
                            </td>
                        </tr>
                        <?php $amountSum += $amount; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="border-top: 1px solid; text-align: center">Total</td>
                        <td class="width2-2" style="border-top: 1px solid; font-weight: bold; text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?>
                        </td>
                    </tr>
                </table>
                <table>
                    <?php foreach ($header->purchasePaymentDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'paymentType.name')); ?></td>
                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td class="width2-2" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" style="border-top: 1px solid; text-align: center">Total</td>
                        <td class="width2-2" style="border-top: 1px solid; font-weight: bold; text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalDetail)); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>