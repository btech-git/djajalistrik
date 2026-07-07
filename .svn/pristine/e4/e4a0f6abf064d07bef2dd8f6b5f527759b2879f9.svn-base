<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 20% }
	.width1-4 { width: 10% }
	.width1-5 { width: 10% }
	.width1-6 { width: 10% }
	.width1-7 { width: 10% }
	.width1-8 { width: 10% }
	.width1-8 { width: 10% }

	.width2-1 { width: 20% }
	.width2-2 { width: 5% }
	.width2-3 { width: 5% }
	.width2-4 { width: 15% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
	.width2-7 { width: 5% }
	.width2-8 { width: 5% }
	.width2-9 { width: 5% }
	.width2-10 { width: 15% }
	.width2-11 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT. DJAJA LISTRIK</div>
    <div style="font-size: larger">Laporan Invoice Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Invoice #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Customer</th>
        <th class="width1-4">Order #</th>
        <th class="width1-5">Branch</th>
        <th class="width1-6">Admin</th>
        <th class="width1-7">Include/Exclude</th>
        <th class="width1-8">Faktur Pajak #</th>
        <th class="width1-9">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="8">
            <table>
                <tr>
                    <th class="width2-1">Nama Barang</th>
                    <th class="width2-2">Quantity</th>
                    <th class="width2-3">Satuan</th>
                    <th class="width2-4">Price List</th>
                    <th class="width2-5">+/- 1(%)</th>
                    <th class="width2-6">+/- 2(%)</th>
                    <th class="width2-7">+/- 3(%)</th>
                    <th class="width2-8">+/- 4(%)</th>
                    <th class="width2-9">+/- 5(%)</th>
                    <th class="width2-10">Harga Satuan</th>
                    <th class="width2-11">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    
    <?php foreach ($invoiceReport->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'number')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
            <td class="width1-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'orderHeader.reference_number')); ?></td>
            <td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
            <td class="width1-7" style="text-align: center"><?php echo ($header->is_tax == 0) ? CHtml::encode(CHtml::value($header, 'orderHeader.taxValue')) : ''; ?></td>
            <td class="width1-8" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'tax_number')); ?></td>
            <td class="width1-9" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="8">
                <table>
                    <?php foreach ($header->invoiceDetails as $detail): ?>
                        <?php $deliveryDetail = $detail->deliveryDetail; ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product_name')); ?></td>
                            <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'unit.name')); ?></td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
                            <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?></td>
                            <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?></td>
                            <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?></td>
                            <td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?></td>
                            <td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?></td>
                            <td class="width2-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price_after_discount'))); ?></td>
                            <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                        
                    <?php foreach ($header->invoiceNewProducts as $newProduct): ?>
                        <?php $deliveryNewProduct = $newProduct->deliveryNewProduct; ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($deliveryNewProduct, 'product_name')); ?></td>
                            <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($newProduct, 'quantity'))); ?></td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($deliveryNewProduct, 'unit.name')); ?></td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'unit_price'))); ?></td>
                            <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_1'))); ?></td>
                            <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_2'))); ?></td>
                            <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_3'))); ?></td>
                            <td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_4'))); ?></td>
                            <td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_5'))); ?></td>
                            <td class="width2-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'unit_price_after_discount'))); ?></td>
                            <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'total'))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                        
                    <tr>
                        <td colspan="10" style="border-top: 1px solid; font-weight: bold; text-align: right">Sub Total</td>
                        <td class="width2-11" style="border-top: 1px solid; font-weight: bold; text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->subTotal)); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="10" style="font-weight: bold; text-align: right">PPN 10%</td>
                        <td class="width2-11" style="font-weight: bold; text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->totalTax)); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="10" style="font-weight: bold; text-align: right">Grand Total</td>
                        <td class="width2-11" style="border-top: 1px solid; font-weight: bold; text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->grand_total)); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
        
    <tr>
        <td colspan="7" style="border-top: 1px solid; font-weight: bold; text-align: right">TOTAL PENJUALAN</td>
        <td class="width1-5" style="border-top: 1px solid; font-weight: bold; text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoiceReport, 'grandTotal'))); ?>
        </td>
    </tr>
</table>