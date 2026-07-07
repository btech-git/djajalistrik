<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 12% }
    .width1-2 { width: 12% }
    .width1-3 { width: 12% }
    .width1-4 { width: 12% }
    .width1-5 { width: 10% }
    .width1-6 { width: 12% }
    .width1-7 { width: 10% }
    .width1-8 { width: 20% }

    .width2-1 { width: 38% }
    .width2-2 { width: 12% }
    .width2-3 { width: 10% }
    .width2-4 { width: 10% }
    .width2-5 { width: 15% }
    .width2-6 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Retur Pembelian Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Retur #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Pembelian #</th>
        <th class="width1-4">Penerimaan #</th>
        <th class="width1-5">Gudang</th>
        <th class="width1-6">Cabang</th>
        <th class="width1-7">Admin</th>
        <th class="width1-8">Catatan</th>
    </tr>
    
    <tr id="header2">
        <td colspan="8">
            <table>
                <tr>
                    <th class="width2-1">Nama Barang</th>
                    <th class="width2-2">Jumlah Terima</th>
                    <th class="width2-3">Jumlah Retur</th>
                    <th class="width2-4">Satuan</th>
                    <th class="width2-5">Harga Satuan</th>
                    <th class="width2-6">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($purchaseReturnReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'receiveHeader.purchaseHeader.number')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'receiveHeader.number')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="8">
                <table>
                    <?php if (count($header->purchaseReturnDetails) > 0): ?>
                        <?php foreach ($header->purchaseReturnDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                                <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'receiveDetail.quantity_receive')); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->receiveDetail->purchaseDetail->unit_price)); ?></td>
                                <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                            
                    <?php if (count($header->purchaseReturnNewProducts) > 0): ?>
                        <?php foreach ($header->purchaseReturnNewProducts as $newProduct): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($newProduct, 'receiveNewProduct.purchaseNewProduct.product_name')); ?></td>
                                <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'receiveNewProduct.quantity')); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'quantity')); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'unit.name')); ?></td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $newProduct->receiveNewProduct->purchaseNewProduct->unit_price)); ?></td>
                                <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $newProduct->total)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                            
                    <tr>
                        <td colspan="5" style="border-top: 1px solid; font-weight: bold; text-align: right">Total</td>
                        <td class="width2-6" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->getGrandTotal($header->receive_header_id))); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="7" style="border-top: 1px solid; font-weight: bold; text-align: right">TOTAL RETUR</td>
        <td class="width1-5" style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseReturnReport, 'grandTotal'))); ?></td>
    </tr>
</table>