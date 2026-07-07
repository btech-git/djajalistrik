<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    $("#body_left_column").addClass("hide");
    $("#login").addClass("hide");
    window.print();
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 5% }
    .hcolumn2 { width: 40% }
    .hcolumn3 { width: 30% }
    .hcolumn4 { width: 25% }

    .hcolumn1value { width: 100% }
    .hcolumn2value { width: 100% }
    .hcolumn3value { width: 100% }
    .hcolumn4value { width: 100% }

    .sig1 { width: 25% }
    .sig2 { width: 50% }
    .sig3 { width: 25% }
');
?>

<div id="detail_div">
    <div id="memoheader">
        <div id="logo"><?php //echo CHtml::image('images/logo.jpg', 'Djaja Listrik');  ?></div>
        <div style="font-size: 150%">PURCHASE ORDER</div>
    </div>

    <br />

    <div class="memonote">
        <div class="divtable">
            <div class="divtablecell hcolumn1">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn1value">Dari:</div>
                    </div>
                </div>
            </div>
            
            <div class="divtablecell hcolumn2">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value" style="font-size:120%;font-weight: bold"><?php echo CHtml::encode($branch->name); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn2value"><?php echo nl2br(CHtml::encode($branch->address)); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="divtablecell hcolumn3">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn3value">Kepada Yth.</div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn3value"><?php echo CHtml::encode($supplier->company); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn3value"><?php echo nl2br(CHtml::encode($supplier->address)); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn3value"><?php echo CHtml::encode($supplier->city); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="divtablecell hcolumn4">
                <div class="divtable">
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn4value" style="text-align: right">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchase, 'date')))); ?></div>
                    </div>
                    
                    <div class="divtablerow">
                        <div class="divtablecell info hcolumn4value" style="text-align: left; font-weight: bold; font-size: 18px">PO #: <br /><?php echo CHtml::encode(CHtml::value($purchase, 'number')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />

    <?php $tax = ((int) $purchase->is_tax === 0) ? 10 : 0; ?>

    <?php if (count($purchaseDetails) > 0): ?>
        <?php $counter = 0; ?>
        <table class="memo">
            <tr id="theader">
                <th style="width: 6%">Kode</th>
                <th>Nama Barang</th>
                <th style="width: 5%">Jumlah</th>
                <th style="width: 5%">Satuan</th>
                <th style="width: 12%">Harga Satuan</th>
                <?php if (!$discountDetailHiddenStatuses[1]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[2]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[3]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[4]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountDetailHiddenStatuses[5]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <th style="width: 12%">Total</th>
            </tr>
            <?php foreach ($purchaseDetails as $i => $detail): ?>
                <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
                <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
                <tr class="titems">
                    <td><?php echo CHtml::encode(CHtml::value($detailProduct, 'code')); ?></td>
                    <td style="font-size: 18px"><?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?></td>
                    <td style="text-align: center; font-size: 18px"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                    <?php if (!$discountDetailHiddenStatuses[1]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_1'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[2]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_2'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[3]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_3'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[4]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_4'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountDetailHiddenStatuses[5]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_5'))); ?></td>
                    <?php endif; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="<?php echo 10 - array_sum($discountDetailHiddenStatuses); ?>" style="border-top: 2px solid; font-weight: bold; text-align: right">Total :</td>
                <td style="border-top: 2px solid; text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->totalDetail)); ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <?php if (count($purchaseNewProducts) > 0): ?>
        <?php $counter = 0; ?>
        <table class="memo">
            <tr id="theader">
                <th style="width: 26%">Nama Barang</th>
                <th style="width: 10%">Merk</th>
                <th style="width: 10%">Jumlah</th>
                <th style="width: 5%">Satuan</th>
                <th style="width: 12%">Harga Satuan</th>
                <?php if (!$discountNewProductHiddenStatuses[1]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountNewProductHiddenStatuses[2]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountNewProductHiddenStatuses[3]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountNewProductHiddenStatuses[4]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <?php if (!$discountNewProductHiddenStatuses[5]): ?>
                    <th style="width: 7%">Disc<?php echo ++$counter; ?> (%)</th>
                <?php endif; ?>
                <th style="width: 12%">Total</th>
            </tr>
            
            <?php foreach ($purchaseNewProducts as $i => $newProduct): ?>
                <?php $newProductUnit = $newProduct->unit(array('scopes' => 'resetScope')); ?>
                <tr class="titems">
                    <td style="font-size: 18px"><?php echo CHtml::encode(CHtml::value($newProduct, 'product_name')); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProduct, 'brand.name')); ?></td>
                    <td style="text-align: center; font-size: 18px"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($newProduct, 'quantity'))); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($newProductUnit, 'name')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($newProduct, 'unit_price'))); ?></td>
                    <?php if (!$discountNewProductHiddenStatuses[1]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_1'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[2]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_2'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[3]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_3'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[4]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_4'))); ?></td>
                    <?php endif; ?>
                    <?php if (!$discountNewProductHiddenStatuses[5]): ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($newProduct, 'discount_5'))); ?></td>
                    <?php endif; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($newProduct, 'total'))); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan ="<?php echo 10 - array_sum($discountNewProductHiddenStatuses); ?>" style="border-top: 2px solid; font-weight: bold; text-align: right">Total :</td>
                <td style="border-top: 2px solid; text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->totalNewProduct)); ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <table class="memo">
        <tr>
            <td style="border-right: 2px solid; font-weight: bold; text-align: right">Sub Total:</td>
            <td style="text-align: right; font-weight: bold; width: 20%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?></td>
        </tr>
        
        <tr>
            <td style="border-right: 2px solid; font-weight: bold; text-align: right">Tax: </td>
            <td style="text-align: right; font-weight: bold; width: 20%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->totalTax)); ?></td>
        </tr>
        
        <tr>
            <td style="border-right: 2px solid; font-weight: bold; text-align: right">Grand Total:</td>
            <td style="text-align: right; font-weight: bold; width: 20%; font-size: 18px"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->grandTotal)); ?></td>
        </tr>
    </table>

    <div style="text-transform: capitalize">
        TERBILANG:
        <?php echo CHtml::encode(NumberWord::numberName(CHtml::value($purchase, 'grandTotal'))); ?>
        rupiah
    </div>

    <br />

    <div>
        CATATAN: <?php echo CHtml::encode(CHtml::value($purchase, 'note_external')); ?>
    </div>

    <br />

    <div class="memosig">
        <div class="divtable">
            <div class="divtablecell sig1">
                <div>DISETUJUI OLEH,</div>
                <br/>
            </div>
            <div class="divtablecell sig2">
                &nbsp;
            </div>
            <div class="divtablecell sig3">
                <div>DIBUAT OLEH,</div>
                <br/><br/><br/>
                <div><?php echo CHtml::encode(CHtml::value($purchase, 'admin.name')); ?></div>
            </div>
        </div>
    </div>
</div>