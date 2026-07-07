<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 20% }
    .width1-4 { width: 15% }
    .width1-5 { width: 20% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 25% }
    .width2-6 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Pembayaran Penjualan Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Pembayaran #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Customer</th>
        <th class="width1-4">Branch</th>
        <th class="width1-5">Catatan</th>
    </tr>
    
    <tr id="header2">
        <td colspan="5">
            <table>
                <tr>
                    <th class="width2-1">Invoice #</th>
                    <th class="width2-2">Tanggal</th>
                    <th class="width2-3">F. Pajak #</th>
                    <th class="width2-4">Jenis Pembayaran</th>
                    <th class="width2-5">Memo</th>
                    <th class="width2-6">Jumlah</th>
                </tr>
            </table>
        </td>
    </tr>
    
    <?php foreach ($salePaymentReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="5">
                <table>
                    <?php foreach ($header->salePaymentDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.number')); ?></td>
                            <td class="width2-2">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->invoiceHeader->date))); ?>
                            </td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.tax_number')); ?></td>
                            <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'paymentType.name')); ?></td>
                            <td class="width2-5"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td class="width2-6" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        
                    <tr>
                        <td colspan="5" style="border-top: 1px solid; text-align: right">Total</td>
                        <td class="width2-6" style="border-top: 1px solid; font-weight: bold; text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalDetail)); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>