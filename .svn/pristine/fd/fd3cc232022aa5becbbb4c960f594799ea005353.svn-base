<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 45% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">PT Djaja Listrik</div>
    <div style="font-size: larger">Laporan All Admin Performance</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
<?php $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
<?php $startDate = $yearMonth . '-01'; ?>
<?php $endDate = $yearMonth . '-' . $daysInMonth; ?>

<fieldset>
    <legend>Order Penjualan</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Customer Total</th>
                <th class="width1-4">Order Total</th>
                <th class="width1-5">Jumlah Order (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $customerQuantitySum = 0; ?>
            <?php $orderQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserSaleOrderReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['invoice_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['invoice_total'])); ?></td>
                </tr>
                <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
                <?php $orderQuantitySum += $dataItem['invoice_quantity']; ?>
                <?php $grandTotalSum += $dataItem['invoice_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($customerQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($orderQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Pengiriman Barang</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-4">Pengiriman Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $deliveryQuantitySum = 0; ?>
            <?php foreach ($monthlyUserDeliveryReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['delivery_quantity']); ?></td>
                </tr>
                <?php $deliveryQuantitySum += $dataItem['delivery_quantity']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($deliveryQuantitySum); ?></td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Invoice Penjualan</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Customer Total</th>
                <th class="width1-4">Invoice Total</th>
                <th class="width1-5">Jumlah Invoice (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $customerQuantitySum = 0; ?>
            <?php $invoiceQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserSaleReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['invoice_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['invoice_total'])); ?></td>
                </tr>
                <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
                <?php $invoiceQuantitySum += $dataItem['invoice_quantity']; ?>
                <?php $grandTotalSum += $dataItem['invoice_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($customerQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($invoiceQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Tanda Terima Penjualan</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Customer Total</th>
                <th class="width1-4">TT Total</th>
                <th class="width1-5">Jumlah TT (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $customerQuantitySum = 0; ?>
            <?php $invoiceQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserSaleReceiptReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['invoice_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['invoice_total'])); ?></td>
                </tr>
                <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
                <?php $invoiceQuantitySum += $dataItem['invoice_quantity']; ?>
                <?php $grandTotalSum += $dataItem['invoice_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($customerQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($invoiceQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Pelunasan Penjualan</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Customer Total</th>
                <th class="width1-4">Pelunasan Total</th>
                <th class="width1-5">Jumlah Pelunasan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $customerQuantitySum = 0; ?>
            <?php $invoiceQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserSalePaymentReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['payment_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_total'])); ?></td>
                </tr>
                <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
                <?php $invoiceQuantitySum += $dataItem['payment_quantity']; ?>
                <?php $grandTotalSum += $dataItem['payment_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($customerQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($invoiceQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Packing List</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-4">Packing Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $packingQuantitySum = 0; ?>
            <?php foreach ($monthlyUserPackingListReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['packing_quantity']); ?></td>
                </tr>
                <?php $packingQuantitySum += $dataItem['packing_quantity']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($packingQuantitySum); ?></td>
            </tr>
        </tfoot>
    </table>
</fieldset>
<fieldset>
    <legend>Order Pembelian</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Supplier Total</th>
                <th class="width1-4">Order Total</th>
                <th class="width1-5">Jumlah Order (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $supplierQuantitySum = 0; ?>
            <?php $orderQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserPurchaseReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['supplier_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['purchase_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['purchase_total'])); ?></td>
                </tr>
                <?php $supplierQuantitySum += $dataItem['supplier_quantity']; ?>
                <?php $orderQuantitySum += $dataItem['purchase_quantity']; ?>
                <?php $grandTotalSum += $dataItem['purchase_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($supplierQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($invoiceQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Penerimaan Barang</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-4">Penerimaan Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $receiveQuantitySum = 0; ?>
            <?php foreach ($monthlyUserReceiveReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['receive_quantity']); ?></td>
                </tr>
                <?php $receiveQuantitySum += $dataItem['receive_quantity']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($receiveQuantitySum); ?></td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Tanda Terima Pembelian</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Supplier Total</th>
                <th class="width1-4">TT Total</th>
                <th class="width1-5">Jumlah TT (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $supplierQuantitySum = 0; ?>
            <?php $receiptQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserPurchaseReceiptReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['supplier_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['purchase_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['purchase_total'])); ?></td>
                </tr>
                <?php $supplierQuantitySum += $dataItem['supplier_quantity']; ?>
                <?php $invoiceQuantitySum += $dataItem['purchase_quantity']; ?>
                <?php $grandTotalSum += $dataItem['purchase_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($supplierQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($invoiceQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<fieldset>
    <legend>Pelunasan Pembelian</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Admin</th>
                <th class="width1-3">Supplier Total</th>
                <th class="width1-4">Pelunasan Total</th>
                <th class="width1-5">Jumlah Pelunasan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $supplierQuantitySum = 0; ?>
            <?php $paymentQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php foreach ($monthlyUserPurchasePaymentReport as $i => $dataItem): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['supplier_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['payment_quantity']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_total'])); ?></td>
                </tr>
                <?php $supplierQuantitySum += $dataItem['supplier_quantity']; ?>
                <?php $paymentQuantitySum += $dataItem['payment_quantity']; ?>
                <?php $grandTotalSum += $dataItem['payment_total']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="border-top: 1px solid; text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($supplierQuantitySum); ?></td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode($paymentQuantitySum); ?></td>
                <td style="text-align: right; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>