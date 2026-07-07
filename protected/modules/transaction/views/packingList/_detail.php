
<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center; width: 55%">Nama Barang</th>
        <th style="text-align: center; width: 10%">Stok</th>
        <th style="text-align: center; width: 10%">Qty Order</th>
        <th style="text-align: center; width: 10%">Qty Packing</th>
        <th style="text-align: center; width: 10%">Satuan</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($packingList->details as $i => $detail): ?>
        <?php $detailOrder = $detail->orderDetail(array('scopes' => 'resetScope')); ?>
        <tr style="background-color: #FFF8DC">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]order_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.product_name')); ?>
            </td>
            
            <td style="text-align: center; width: 10%">
                <?php echo CHtml::hiddenField("current_stock_{$i}", ($currentStock = $detail->getCurrentStock($packingList->header->warehouse_id))); ?>
                <span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $currentStock)); ?></span>
            </td>
            
            <td style="text-align:center">
                <?php echo CHtml::hiddenField("quantity_ordered_{$i}", ($quantityOrdered = $detail->orderDetail->getRemainingQuantityPacking())); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityOrdered)); ?>
            </td>
            
            <td style="text-align: center">
                <?php $minQtyStatement = ($detailOrder->product_id === null) ? ('var minQty = parseInt($("#quantity_ordered_' . $i . '").val());') : ('var minQty = Math.min(parseInt($("#quantity_ordered_' . $i . '").val()), parseInt($("#current_stock_' . $i . '").val()));'); ?>
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 7,
//                    'onchange' => $minQtyStatement . '
//                        if (parseInt($(this).val()) > minQty) 
//                            $(this).val(minQty)',
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            
            <td>
                <?php echo CHtml::encode(CHtml::value($detailOrder, 'unit.name')); ?>
            </td>
            
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $packingList->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>
<?php endforeach; ?>
</table>