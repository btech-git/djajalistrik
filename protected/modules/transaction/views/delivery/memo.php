<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 50% }
    .hcolumn2value { width: 50% }

    .sig1 { width: 15% }
    .sig2 { width: 15% }
    .sig3 { width: 15% }
    .sig4 { width: 15% }
    .sig5 { width: 15% }
    .sig6 { width: 25% }
');
?>

<?php /*$countDetail = count($delivery->deliveryDetails); ?>
<?php $countNewProduct = count($delivery->deliveryNewProducts); ?>
<?php $count = $countDetail + $countNewProduct; ?>

<?php $pageSize = 16; ?>
<?php $pageNumber = intval($count / $pageSize) + intval($count % $pageSize > 0); ?>
<?php $pageNumber = ($pageNumber > 0) ? $pageNumber : 1; ?>

<?php foreach (range(1, $pageNumber) as $num):*/ ?>
    <div id="detail_div_memo">
        <div id="memoheader">
            <div style="font-size: larger">Surat Jalan</div>
        </div>

        <br />

        <div>
            <div class="divtable">
                <div class="divtablecell hcolumn1">
                    <div class="divtable">
                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn1value" style="font-size:120%;font-weight: bold"><?php echo CHtml::encode($branch->name); ?></div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn1value"><?php echo nl2br(CHtml::encode($branch->address)); ?></div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn1value">Telp. <?php echo CHtml::encode($branch->phone); ?> Fax. <?php echo CHtml::encode($branch->fax); ?></div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn1header" style="font-weight: bold">NO.SJ &nbsp : <?php echo CHtml::encode(CHtml::value($delivery, 'number')); ?></div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn1header" style="font-weight: bold">NO.PO &nbsp : <?php echo CHtml::encode(CHtml::value($delivery, 'orderHeader.reference_number')); ?></div>
                        </div>
                    </div>
                </div>

                <div class="divtablecell hcolumn2">
                    <div class="divtable">
                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn2value" style="text-align: right;">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($delivery, 'date')))); ?></div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn2header">Kepada Yth.</div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($order->customer->company); ?> &nbsp (<?php echo CHtml::encode($order->customer->name); ?>)</div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($order->customer->address_1); ?></div>
                        </div>

                        <div class="divtablerow">
                            <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($order->customer->city); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <table class="memo">
            <tr id="theader">
                <th style="width: 5%">No</th>
                <th>Nama Produk</th>
                <th style="width: 20%">Jumlah</th>
                <th style="width: 20%">Satuan</th>
            </tr>
            <?php $counter = 1;?>

            <?php if (count($deliveryDetails) > 0): ?> 
                <?php foreach ($deliveryDetails as $i => $detail): ?>
                    <?php //if ($i <= $num * $pageSize - 1 && $i >= ($num - 1) * $pageSize): ?>
                        <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
                        <tr class="titems">
                            <td style="text-align: center"><?php echo $counter; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.product_name')); ?></td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                            </td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                    <?php //endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (count($deliveryNewProducts) > 0): ?>
                <?php foreach ($deliveryNewProducts as $j => $detail): ?>
                    <?php //$j += !empty($i) ? $i + 1 : 1; ?>
                    <?php //if ($j <= $num * $pageSize - 1 && $j >= ($num - 1) * $pageSize): ?>
                        <tr class="titems">
                            <td style="text-align: center"><?php echo $counter; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'orderNewProduct.name')); ?></td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                            </td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(CHtml::value($detail, 'orderNewProduct.unit.name')); ?>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                    <?php //endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (count($deliveryDetails) > 0 || count($deliveryNewProducts) > 0): ?>
                <?php for ($j = 17, $counter = $counter % $j + 1; $j > $counter; $j--): ?>
                    <tr class="titems">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
            <tr class="titems">
                <td colspan="2" style="font-weight: bold; text-align: right; border-top: 1px solid">TOTAL: </td>
                <td style="font-weight: bold; text-align: center; border-top: 1px solid"><?php echo CHtml::encode(CHtml::value($delivery, 'totalQuantity')); ?></td>
                <td style="border-top: 1px solid">&nbsp;</td>
            </tr>
        </table>
        
        <div class="row">Catatan: <?php echo nl2br(CHtml::encode(CHtml::value($delivery, 'note'))); ?></div>

        <br />

        <div class="memosig">
            <div class="divtable">

                <div class="divtablecell sig2">
                    <div>Hormat Kami,</div>
                </div>

                <div class="divtablecell sig2">
                    <div>Pengirim,</div>
                </div>

                <div class="divtablecell sig1">
                    <div>Dibuat Oleh,</div>
                    <br/><br/><br/>
                    <div><?php echo CHtml::encode(CHtml::value($delivery, 'admin.name')); ?></div>
                </div>

                <div class="divtablecell sig2">
                    <div>Diperiksa Oleh,</div>
                </div>

                <div class="divtablecell sig2">
                    <div>Diterima Oleh,</div>
                </div>
            </div>
        </div>
    </div>
<?php //endforeach; ?>