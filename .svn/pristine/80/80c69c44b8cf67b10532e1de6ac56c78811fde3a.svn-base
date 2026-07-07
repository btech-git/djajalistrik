<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 12% }
	.width1-2 { width: 12% }
	.width1-3 { width: 12% }
	.width1-4 { width: 12% }
	.width1-5 { width: 16% }
	.width1-6 { width: 12% }
	.width1-7 { width: 12% }
	.width1-8 { width: 12% }

	.width2-1 { width: 55% }
	.width2-2 { width: 15% }
	.width2-3 { width: 15% }
	.width2-4 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Penerimaan Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Penerimaan #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Pembelian #</th>
        <th class="width1-4">Order #</th>
        <th class="width1-5">Supplier</th>
        <th class="width1-6">Referensi</th>
        <th class="width1-7">Gudang</th>
        <th class="width1-8">Branch</th>
    </tr>
    <tr id="header2">
        <td colspan="8">
            <table>
                <tr>
                    <th class="width2-1">Nama Barang</th>
                    <th class="width2-2">Jumlah Order</th>
                    <th class="width2-3">Jumlah Terima</th>
                    <th class="width2-4">Satuan</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($receiveReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'purchaseHeader.number')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'purchaseHeader.orderHeader.number')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'purchaseHeader.supplier.company')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'reference')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="8">
                <table>
                    <?php foreach ($header->receiveDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity_order')); ?></td>
                            <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity_receive')); ?></td>
                            <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php foreach ($header->receiveNewProducts as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseNewProduct.product_name')); ?></td>
                            <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseNewProduct.quantity')); ?></td>
                            <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                            <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseNewProduct.unit.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>