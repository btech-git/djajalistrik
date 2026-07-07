<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    $("#body_left_column").addClass("hide");
    $("#login").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 35% }
    .sig2 { width: 5% }
    .sig3 { width: 5% }
    .sig4 { width: 15% }
    .sig5 { width: 5% }
    .sig6 { width: 5% }
    .sig7 { width: 5% }
    .sig8 { width: 5% }
    .sig9 { width: 5% }
    .sig10 { width: 15% }
');
?>
<div id="detail_div_memo">
    <div id="memoheader">
        <div style="font-size: 150%; font-weight: bolder">SALES ORDER</div>
    </div>

    <br />

    <div class="memonote">
        <div class="divtable">
            <div class="divtablecell hcolumn1">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value">Order: <?php echo CHtml::encode($branch->name); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1header">SO# : <?php echo CHtml::encode(CHtml::value($order, 'number')); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value">Tanggal: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($order, 'date')))); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value">PO Customer:<?php echo CHtml::encode(CHtml::value($order, 'reference_number')); ?></div>
                    </div>
                </div>
            </div>
            <div class="divtablecell hcolumn2">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value">Customer: <?php echo CHtml::encode($customer->name); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->address_1); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->city); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />

    <?php $counter = 0; ?>
    <table class="memo">
        <tr id="theader">
            <th class="sig1">Nama Produk</th>
            <th class="sig2">Jumlah</th>
            <th class="sig3">Satuan</th>
            <th class="sig4">Harga Satuan</th>
            <?php if (!$discountDetailHiddenStatuses[1] || !$discountNewProductHiddenStatuses[1]): ?>
                <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
            <?php endif; ?>
                
            <?php if (!$discountDetailHiddenStatuses[2] || !$discountNewProductHiddenStatuses[2]): ?>
                <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
            <?php endif; ?>
                
            <?php if (!$discountDetailHiddenStatuses[3] || !$discountNewProductHiddenStatuses[3]): ?>
                <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
            <?php endif; ?>
                
            <?php if (!$discountDetailHiddenStatuses[4] || !$discountNewProductHiddenStatuses[4]): ?>
                <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
            <?php endif; ?>
                
            <?php if (!$discountDetailHiddenStatuses[5] || !$discountNewProductHiddenStatuses[5]): ?>
                <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
            <?php endif; ?>
                
            <th class="sig10">Total</th>
        </tr>
        <?php if (count($orderDetails) > 0): ?>
            <?php foreach ($orderDetails as $i => $detail): ?>
                <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
                <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
                <tr class="titems">
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_single'))); ?>
                    </td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price_single'))); ?>
                    </td>
                    <?php if (!$discountDetailHiddenStatuses[1] || !$discountNewProductHiddenStatuses[1]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_1'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[2] || !$discountNewProductHiddenStatuses[2]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_2'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[3] || !$discountNewProductHiddenStatuses[3]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_3'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[4] || !$discountNewProductHiddenStatuses[4]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_4'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[5] || !$discountNewProductHiddenStatuses[5]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_5'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (count($orderNewProducts) > 0): ?>
            <?php foreach ($orderNewProducts as $i => $detail): ?>
                <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
                <tr class="titems">
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                    </td>
                    <?php if (!$discountDetailHiddenStatuses[1] || !$discountNewProductHiddenStatuses[1]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_1'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[2] || !$discountNewProductHiddenStatuses[2]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_2'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[3] || !$discountNewProductHiddenStatuses[3]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_3'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[4] || !$discountNewProductHiddenStatuses[4]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_4'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <?php if (!$discountDetailHiddenStatuses[5] || !$discountNewProductHiddenStatuses[5]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_5'))); ?>
                        </td>
                    <?php endif; ?>
                        
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

        <tr>
            <td style="border-top: 2px solid; font-weight: bold; text-align: right;" colspan="<?php echo 9 - array_sum(count($discountDetailHiddenStatuses) > 0 ? $discountDetailHiddenStatuses : $discountNewProductHiddenStatuses); ?>">SubTotal</td>
            <td style="border-top: 2px solid; font-weight: bold; text-align: right;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'subTotal'))); ?>
            </td>
        </tr>
        <?php if ($order->is_tax == 0): ?>
        <tr>
            <td style="border-top: 2px solid; text-align: right" colspan="<?php echo 9 - array_sum(count($discountDetailHiddenStatuses) > 0 ? $discountDetailHiddenStatuses : $discountNewProductHiddenStatuses); ?>">
                PPN <?php echo CHtml::encode(CHtml::value($order, 'tax')); ?>%
            </td>
            <td style="border-top: 2px solid; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'totalTax'))); ?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td style="text-align: right" colspan="<?php echo 9 - array_sum(count($discountDetailHiddenStatuses) > 0 ? $discountDetailHiddenStatuses : $discountNewProductHiddenStatuses); ?>">Deposit</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'deposit'))); ?></td>
        </tr>
        
        <tr>
            <td style="text-align: right" colspan="<?php echo 9 - array_sum(count($discountDetailHiddenStatuses) > 0 ? $discountDetailHiddenStatuses : $discountNewProductHiddenStatuses); ?>">Ongkos Kirim</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'shipping_fee'))); ?></td>
        </tr>
        
        <tr>
            <td style="font-weight: bold; text-align: right" colspan="<?php echo 9 - array_sum(count($discountDetailHiddenStatuses) > 0 ? $discountDetailHiddenStatuses : $discountNewProductHiddenStatuses); ?>">Grand Total</td>
            <td style="font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', round($order->grandTotal, -1))); ?></td>
        </tr>
    </table>

    <div style="text-transform: capitalize">
        CATATAN:
        <?php echo CHtml::encode(CHtml::value($order, 'note_external')); ?>
    </div>

    <br/>

    <div style="text-transform: capitalize">
        TERBILANG:
        <?php echo CHtml::encode(NumberWord::numberName(round(($order->grandTotal > 1000000) ? round($order->grandTotal, -3) : round($order->grandTotal, -2)))); ?>
        rupiah
    </div>

    <br />

    <div class="memosig">
        <div class="divtable">
            <div class="divtablecell sig1">
                &nbsp;
            </div>
            <div class="divtablecell sig2">
                &nbsp;
            </div>
            <div class="divtablecell sig3">
                <div>DIBUAT OLEH,</div>
                <br/><br/><br/>
                <div><?php echo CHtml::encode(CHtml::value($order, 'admin.name')); ?></div>
            </div>
        </div>
    </div>
</div>
