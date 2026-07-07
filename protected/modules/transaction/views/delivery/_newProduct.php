<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center; width: 55%">Nama Barang</th>
        <th style="text-align: center; width: 10%">Jumlah Order</th>
        <th style="text-align: center; width: 10%">Jumlah Terima</th>
        <th style="text-align: center; width: 10%">Jumlah Kirim</th>
        <th style="text-align: center; width: 10%">Satuan</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($delivery->newProducts as $i => $detail): ?>

        <?php $detailOrder = $detail->orderNewProduct(array('scopes' => 'resetScope')); ?>
        <?php $detailUnit = $detail->orderNewProduct->unit(array('scopes' => 'resetScope')); ?>

        <tr style="background-color: #FFF8DC">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]order_new_product_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
            </td>
            
            <td style="text-align:center">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->orderNewProduct->quantity)); ?>
            </td>
            
            <td style="text-align:center">
                <?php echo CHtml::hiddenField("quantity_new_product_ordered_{$i}", ($quantityOrdered = $detail->orderNewProduct->quantity_receive_remaining)); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityOrdered)); ?>
            </td>
            
            <td style="text-align: center">
                <?php $minQtyStatement = ('var minQty = parseInt($("#quantity_new_product_ordered_' . $i . '").val());'); ?>
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 7,
                    'onchange' => $minQtyStatement . '
                        if (parseInt($(this).val()) > minQty) 
                            $(this).val(minQty)
                    ',
                )); ?>
                <?php //echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'orderNewProduct.unit.name')); ?>
            </td>
            
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveNewProduct', array('id' => $delivery->header->id, 'index' => $i)),
                            'update' => '#detail_new_product',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
                        ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>