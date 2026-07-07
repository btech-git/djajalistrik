<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center">Stok</th>
        <th style="text-align: center">Quantity</th>
        <th style="text-align: center">Satuan</th>
        <th style="text-align: center">Harga Satuan</th>
        <th style="text-align: center">+/-(%) 1</th>
        <th style="text-align: center">+/-(%) 2</th>
        <th style="text-align: center">+/-(%) 3</th>
        <th style="text-align: center">+/-(%) 4</th>
        <th style="text-align: center">+/-(%) 5</th>
        <th style="text-align: center">Total</th>
        <th style="text-align: center"></th>
    </tr>
    
    <?php foreach ($order->details as $i=>$detail): ?>
        <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
        <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>

        <tr style="background-color: #FFF8DC">
            <td style="width: auto">
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::activeTextField($detail, "[$i]product_name"); ?>
            </td>
            <td style="text-align: center; width: 10%">
                <?php echo CHtml::hiddenField("current_stock_{$i}", ($currentStock = CHtml::value($detail, 'product.totalStock'))); ?>
                <span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $currentStock)); ?></span>
            </td>
            <td style="text-align: center; width: 10%">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity_single", array(
                    'size'=>7, 
                    'maxLength'=>20,
                    'onchange'=>CHtml::ajax(array(
                        'type'=>'POST',
                        'dataType'=>'JSON',
                        'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                        'success'=>'function(data) {
                            $("#total_'.$i.'").html(data.total);
                            $("#sub_total").html(data.subTotal);	
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                Bulk: <span id="product_quantity_bulk_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, 'product.quantity_bulk')); ?></span>
                <?php echo CHtml::error($detail, 'quantity_single'); ?>
            </td>
            <td style="text-align: right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php echo CHtml::openTag('span', array('id' => "unit_name_$i")); ?>
                    <?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </td>

            <?php if (Yii::app()->user->checkAccess('administrator')): ?>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]unit_price_single", array('size'=>9, 'maxLength'=>10,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);	
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'unit_price_bulk'); ?>
                    <?php echo CHtml::error($detail, 'unit_price_single'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]discount_1", array(
                        'size'=>3, 
                        'maxLength'=>10,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'discount_1'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]discount_2", array(
                        'size'=>3, 
                        'maxLength'=>10,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'discount_2'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]discount_3", array(
                        'size'=>3, 
                        'maxLength'=>10,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'discount_3'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]discount_4", array(
                        'size'=>3, 
                        'maxLength'=>10,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'discount_4'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]discount_5", array(
                        'size'=>3, 
                        'maxLength'=>10,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'discount_5'); ?>
                </td>
            <?php else: ?>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price_single"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price_single'))); ?>
                    <?php echo CHtml::error($detail, 'unit_price_single'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]discount_1"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?>
                    <?php echo CHtml::error($detail, 'discount_1'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]discount_2"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?>
                    <?php echo CHtml::error($detail, 'discount_2'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]discount_3"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?>
                    <?php echo CHtml::error($detail, 'discount_3'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]discount_4"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?>
                    <?php echo CHtml::error($detail, 'discount_4'); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]discount_5"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?>
                    <?php echo CHtml::error($detail, 'discount_5'); ?>
                </td>
            <?php endif; ?>

            <td style="text-align: right">
                <span id="total_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                </span>
            </td>
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id'=>$order->header->id, 'index'=>$i)),
                            'update'=>'#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'), array(
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$order->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#unit_price_'.$i.'").html(data.unit_price);
                                $("#total_'.$i.'").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: #F5DEB3">
        <td colspan="10" style="text-align: right; font-weight: bold">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="sub_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $order->totalDetail)); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>