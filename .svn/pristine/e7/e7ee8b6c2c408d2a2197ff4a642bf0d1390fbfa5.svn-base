<?php if ($error === true && count($receive->details) === 0): ?>
    <p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
<?php endif; ?>

<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center; width: 55%">Nama Barang</th>
        <?php if (!empty($receive->header->purchase_header_id) && $receive->header->isNewRecord): ?>
            <th style="text-align: center; width: 15%">Jumlah Pesan</th>
        <?php endif; ?>
        <th style="text-align: center; width: 15%">Jumlah Terima</th>
        <th style="text-align: center; width: 10%">Satuan</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($receive->details as $i => $detail): ?>

        <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
        <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>

        <tr style="background-color: #FFF8DC">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]purchase_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?>
            </td>
            <?php if (!empty($receive->header->purchase_header_id) && $receive->header->isNewRecord): ?>
                <td style="text-align:right; width: 15%">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_order"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'quantity_order')); ?>
                </td>
            <?php endif; ?>
                
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity_receive", array(
                    'onchange' => '
                        if (parseInt($(this).val()) > parseInt($("#' . CHtml::activeId($detail, "[$i]quantity_order") . '").val())) 
                            $(this).val($("#' . CHtml::activeId($detail, "[$i]quantity_order") . '").val())
                    ',
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td style="text-align:right; width: 15%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
            </td>
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $receive->header->id, 'index' => $i)),
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

<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center">Nama Barang</th>
        <?php if (!empty($receive->header->purchase_header_id) && $receive->header->isNewRecord): ?>
            <th style="text-align: center">Jumlah Beli</th>
        <?php endif; ?>
        <th style="text-align: center">Jumlah</th>
        <th style="text-align: center"></th>
    </tr>
    <?php foreach ($receive->newProducts as $i => $newProduct): ?>

        <?php $purchaseNewProduct = $newProduct->purchaseNewProduct(array(
            'scopes' => 'resetScope',
            'with' => array(
                'productClassification:resetScope'
            ),
        )); ?>

        <tr  style="background-color: #FFF8DC">
            <td>
                <?php echo CHtml::activeHiddenField($newProduct, "[$i]purchase_new_product_id"); ?>
                <?php echo CHtml::activeHiddenField($newProduct, "[$i]order_new_product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($newProduct, 'purchaseNewProduct.product_name')); ?>
            </td>
            
            <?php if (!empty($receive->header->purchase_header_id) && $receive->header->isNewRecord): ?>
                <td style="text-align:right; width: 10%">
                    <?php echo CHtml::hiddenField("quantity_ordered_{$i}", ($quantityOrdered = $newProduct->purchaseNewProduct->quantity_remaining)); ?>
                    <span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityOrdered)); ?></span>
                </td>
            <?php endif; ?>
                
            <td style="text-align:center; width: 10%">
                <?php echo CHtml::activeTextField($newProduct, "[$i]quantity", array('size' => 7, 'maxLength' => 20,
                    'onchange' => 'if (parseInt($(this).val()) > parseInt($("#quantity_ordered_' . $i . '").val())) $(this).val($("#quantity_ordered_' . $i . '").val());'
//					CHtml::ajax(array(
//						'type'=>'POST',
//						'dataType'=>'JSON',
//						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$receive->header->id, 'index'=>$i)),
//						'success'=>'function(data) {
//							$("#total_'.$i.'").html(data.total);
//							$("#grand_total").html(data.grandTotal);
//						}',
//					)),
                )); ?>
                <?php echo CHtml::error($newProduct, 'quantity'); ?>
            </td>
            
            <td style="width: 5%">
                <?php if ($newProduct->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveNewProduct', array('id' => $receive->header->id, 'index' => $i)),
                            'update' => '#newProduct_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($newProduct, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>