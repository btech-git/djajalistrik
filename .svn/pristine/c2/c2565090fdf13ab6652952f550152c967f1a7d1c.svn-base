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

	.width2-1 { width: 40% }
	.width2-2 { width: 15% }
	.width2-3 { width: 15% }
	.width2-4 { width: 15% }
	.width2-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Pengiriman Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Pengiriman #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Order #</th>
        <th class="width1-4">Customer</th>
        <th class="width1-5">Gudang</th>
        <th class="width1-6">Branch</th>
        <th class="width1-7">Admin</th>
        <th class="width1-8">Packing #</th>
        <th class="width1-9">Catatan</th>
        <th class="width1-10">Note Internal</th>
    </tr>
    
    <tr id="header2">
        <td colspan="10">
            <table>
                <tr>
                    <th class="width2-1">Nama Barang</th>
                    <th class="width2-2">Jumlah Order</th>
                    <th class="width2-3">Jumlah Kirim</th>
                    <th class="width2-4">Jumlah Retur</th>
                    <th class="width2-5">Satuan</th>
                </tr>
            </table>
        </td>
    </tr>
    
    <?php foreach ($deliveryReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'orderHeader.number')); ?></td>
            <td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'orderHeader.customer.company')); ?></td>
            <td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
            <td class="width1-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-7" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
            <td class="width1-8" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'packingListHeader.number')); ?></td>
            <td class="width1-9" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
            <td class="width1-10" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note_internal')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="10">
                <table>
                    <?php if (count($header->deliveryDetails) > 0): ?>
                        <?php foreach ($header->deliveryDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                                <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.quantity_single')); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity_return')); ?></td>
                                <td class="width2-5"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (count($header->deliveryNewProducts) > 0): ?>
                        <?php foreach ($header->deliveryNewProducts as $newProduct): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($newProduct, 'product_name')); ?></td>
                                <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'orderNewProduct.quantity')); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'quantity')); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'quantity_return')); ?></td>
                                <td class="width2-5"><?php echo CHtml::encode(CHtml::value($newProduct, 'orderNewProduct.unit.name')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tr>
                        <td colspan="2" style="font-weight: bold; text-align: right">Total</td>
                        <td style="font-weight: bold; text-align: center; border-top: 1px solid"><?php echo CHtml::encode(CHtml::value($header, 'totalQuantity')); ?></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>