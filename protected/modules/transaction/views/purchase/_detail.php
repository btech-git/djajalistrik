<?php /* if ($error === true && count($purchase->details) === 0): ?>
  <p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
  <?php endif; */ ?>

<table style="border: 1px solid; width: 950px">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center">Kode</th>
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center">Brand</th>
        <th style="text-align: center">Jenis</th>
        <th style="text-align: center">Stok</th>
        <th style="text-align: center">Jml Beli</th>
        <th style="text-align: center">Satuan</th>
        <?php if (!empty($purchase->header->order_header_id)): ?>
            <th style="text-align: center">Harga Jual</th>
        <?php endif; ?>
        <th style="text-align: center">Harga Satuan</th>
        <th style="text-align: center">+/-(%) 1</th>
        <th style="text-align: center">+/-(%) 2</th>
        <th style="text-align: center">+/-(%) 3</th>
        <th style="text-align: center">+/-(%) 4</th>
        <th style="text-align: center">+/-(%) 5</th>
        <th style="text-align: center">Unit Price</th>
        <th style="text-align: center">Total</th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($purchase->details as $i => $detail): ?>

        <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
        <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>

        <tr style="background-color: #FFF8DC">
            <td style="width: 10%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]order_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailProduct, 'code')); ?>
            </td>
            
            <td style="width: 15%">
                <?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?>
            </td>
            
            <td>
                <?php echo CHtml::encode(CHtml::value($detailProduct, 'brand.name')); ?>
            </td>
            
            <td style="width: 10%">
                <?php echo CHtml::encode(CHtml::value($detailProduct, 'type')); ?>
            </td>

            <td style="text-align:center; width: 10%">
                <?php echo CHtml::encode(CHtml::value($detailProduct, 'stock')); ?>
            </td>

            <td style="text-align:center; width: 10%">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 3,
                    'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
            </td>

                <?php if (!empty($purchase->header->order_header_id)): ?>
                    <td style="text-align:center">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price_sale_order"); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->unit_price_sale_order)); ?>
                    </td>
                <?php endif; ?>

            <td style="text-align: center; width: 10%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                <?php echo CHtml::activeTextField($detail, "[$i]unit_price", array(
                    'size' => 7,
                    'maxLength' => 18,
                    'onchange' =>
//					'
//                        if (parseInt($(this).val()) > parseInt($("#'. CHtml::activeId($detail, "[$i]unit_price_sale_order") .'").val())) $(this).val($("#'. CHtml::activeId($detail, "[$i]unit_price_sale_order") .'").val());
//                    ' .
                    CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);	
                            $("#sub_total").html(data.totalDetail);
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <div id="unit_price_<?php echo $i; ?>" style="text-align: left; font-size: smaller">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]discount_1", array('size' => 3, 'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);	
                            $("#sub_total").html(data.totalDetail);
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'discount_1'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]discount_2", array('size' => 3, 'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'discount_2'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]discount_3", array('size' => 3, 'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);	
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'discount_3'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]discount_4", array('size' => 3, 'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'discount_4'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]discount_5", array('size' => 3, 'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#unit_price_' . $i . '").html(data.unit_price);
                            $("#price_after_discount_' . $i . '").html(data.price_after_discount);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail").html(data.totalDetail);
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'discount_5'); ?>
            </td>
            
            <td style="text-align: right; width: 20%">
                <span id="price_after_discount_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'priceAfterDiscount'))); ?>
                </span>
            </td>
            
            <td style="text-align: right; width: 20%">
                <span id="total_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                </span>
            </td>
            
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $purchase->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'), array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#unit_price_' . $i . '").html(data.unit_price);
                                $("#total_' . $i . '").html(data.total);
                                $("#total_detail").html(data.totalDetail);
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
        <?php if (!empty($purchase->header->order_header_id)): ?>
            <td>&nbsp;</td>
        <?php endif; ?>
        <td colspan="14" style="text-align: right; font-weight: bold">Total:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="total_detail">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($purchase->totalDetail > 1000000) ? round($purchase->totalDetail, -3) : round($purchase->totalDetail, -2))); ?>
            </span>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>