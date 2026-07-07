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

    .sig1 { width: 25% }
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
        <div style="font-size: 150%; font-weight: bolder">FAKTUR PENJUALAN</div>
    </div>

    <br />

    <div class="memonote">
        <div class="divtable">
            <div class="divtablecell hcolumn1">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value" style="font-size:120%;font-weight: bold"><?php echo CHtml::encode($branch->name); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value"><?php echo nl2br(CHtml::encode(CHtml::value($branch, 'address'))); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value">Telp. <?php echo CHtml::encode($branch->phone); ?> Fax. <?php echo CHtml::encode($branch->fax); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1header" style="font-weight: bold">FAKTUR NO.&nbsp : <?php echo CHtml::encode(CHtml::value($order, 'number')); ?></div>
                    </div>
                </div>
            </div>
            <div class="divtablecell hcolumn2">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value" style=text-align:right;>Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($order, 'date')))); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2header">Kepada Yth.</div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->name); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->address_1); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->city); ?></div>
                    </div>
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1header" style="font-weight: bold">PO Customer&nbsp : <?php echo CHtml::encode(CHtml::value($order, 'reference_number')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />

    <?php $counter = 0; ?>
    <table class="memo">
        <tr id="theader">
            <th style="width: 5%">No.</th>
            <th class="sig1">Nama Produk</th>
            <th class="sig2">Quantity</th>
            <th class="sig4">Harga Satuan</th>
            <?php if (!$discountDetailHiddenStatuses[1]): ?>
                <th style="width: 7%">Disc<?php echo++$counter; ?> (%)</th>
            <?php endif; ?>
            <?php if (!$discountDetailHiddenStatuses[2]): ?>
                <th style="width: 7%">Disc<?php echo++$counter; ?> (%)</th>
            <?php endif; ?>
            <?php if (!$discountDetailHiddenStatuses[3]): ?>
                <th style="width: 7%">Disc<?php echo++$counter; ?> (%)</th>
            <?php endif; ?>
            <?php if (!$discountDetailHiddenStatuses[4]): ?>
                <th style="width: 7%">Disc<?php echo++$counter; ?> (%)</th>
            <?php endif; ?>
            <?php if (!$discountDetailHiddenStatuses[5]): ?>
                <th style="width: 7%">Disc<?php echo++$counter; ?> (%)</th>
            <?php endif; ?>
            <th class="sig10">Total</th>
        </tr>

        <?php $nomor = 1; ?>
        <?php if (count($orderDetails) > 0): ?>
            <?php foreach ($orderDetails as $i => $detail): ?>
                <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
                <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
                <tr class="titems">
                    <td style="text-align: center"><?php echo $nomor; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_single'))); ?>
                        <?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price_single'))); ?>
                    </td>
                    <?php if (!$discountDetailHiddenStatuses[1]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[2]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[3]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[4]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[5]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?>
                        </td>
                    <?php endif; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                    </td>
                </tr>
                <?php $nomor++; ?>
            <?php endforeach; ?>
            <tr>
                <td style="border-top: 2px solid; font-weight: bold; text-align: right;border-left: 1px solid;border-bottom: 1px solid" colspan="<?php echo 9 - array_sum($discountDetailHiddenStatuses); ?>">SubTotal</td>
                <td style="border-top: 2px solid; font-weight: bold; text-align: right;border-bottom: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'totalDetail'))); ?></td>
            </tr>
        <?php endif; ?>
        <?php if (count($orderNewProducts) > 0): ?>
            <tr id="theader">
                <?php $counter = 0; ?>
                <th style="width: 5%; border-top:1px solid;">No.</th>
                <th class="sig1" style="border-top:1px solid;">Nama Produk</th>
                <th class="sig2" style="border-top:1px solid;">Quantity</th>
                <th class="sig4" style="border-top:1px solid;">Harga Satuan</th>
                <?php if (!$discountDetailHiddenStatuses[1]): ?>
                    <th style="width: 7%;border-top:1px solid;">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[2]): ?>
                    <th style="width: 7%;border-top:1px solid;" >Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[3]): ?>
                    <th style="width: 7%;border-top:1px solid;" >Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[4]): ?>
                    <th style="width: 7%;border-top:1px solid;" >Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[5]): ?>
                    <th style="width: 7%;border-top:1px solid;">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <th class="sig10" style="border-top:1px solid;">Total</th>
            </tr>

            <?php foreach ($orderNewProducts as $i => $detail): ?>
                <tr class="titems">
                    <td style="text-align: center"><?php echo $nomor; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'name')); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                    </td>
                    <?php if (!$discountNewProductHiddenStatuses[1]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[2]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[3]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[4]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[5]): ?>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?>
                        </td>
                    <?php endif; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                    </td>
                </tr>
                <?php $nomor++; ?>
            <?php endforeach; ?>
            <tr>
                <td style="border-top: 2px solid; font-weight: bold; text-align: right;" colspan="<?php echo 9 - array_sum($discountDetailHiddenStatuses); ?>">SubTotal</td>
                <td style="border-top: 2px solid; font-weight: bold; text-align: right;">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'totalNewProduct'))); ?>
                </td>
            </tr>  
        <?php endif; ?>  
        <?php if ($order->is_tax == 0): ?>
            <tr>
                <td style="text-align: right" colspan="<?php echo 9 - array_sum($discountDetailHiddenStatuses); ?>">
                    PPN <?php echo CHtml::encode(CHtml::value($order, 'tax')); ?>%
                </td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'totalTax'))); ?></td>
            </tr>
        <?php endif; ?> 
        <tr>    
            <td style="text-align: right" colspan="<?php echo 9 - array_sum($discountDetailHiddenStatuses); ?>">Deposit</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'deposit'))); ?></td>
        </tr>
        <tr>
            <td style="text-align: right" colspan="<?php echo 9 - array_sum($discountDetailHiddenStatuses); ?>">Ongkos Kirim</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($order, 'shipping_fee'))); ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: right" colspan="<?php echo 9 - array_sum($discountDetailHiddenStatuses); ?>">Grand Total</td>
            <td style="font-weight: bold; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($order->grandTotal > 1000000) ? round($order->grandTotal, -3) : round($order->grandTotal, -2))); ?>
            </td>
        </tr>
    </table>

    <div style="text-transform: capitalize">
        TERBILANG:
        <?php echo CHtml::encode(NumberWord::numberName(round(($order->grandTotal > 1000000) ? round($order->grandTotal, -3) : round($order->grandTotal, -2)))); ?>
        rupiah
    </div>

    <br />

    <div style="text-transform: capitalize">
        # BARANG YANG SUDAH DI BELI TIDAK DAPAT DI KEMBALIKAN #
    </div>

    <br />

    <div class="memosig">
        <div class="divtable">
            <div class="divtablecell sig1">
                <div>HORMAT KAMI,</div>
                <br/>
                <div><?php //echo CHtml::image('images/barrackobama.jpg', 'CEO Signature', array('style' => 'height: 50px'));       ?></div>
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
