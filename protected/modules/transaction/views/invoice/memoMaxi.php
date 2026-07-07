<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
    
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 70% }
    .sig2 { width: 30% }

    table.memo
    {
        border-left: 0px solid;
        border-bottom: 0px solid;
        border-right: 0px solid;
    }
    
    .memonote {width: 100% !important;}
		
'); ?>

<?php /*$countDetail = count($invoice->invoiceDetails); ?>
<?php $countNewProduct = count($invoice->invoiceNewProducts); ?>
<?php $count = $countDetail + $countNewProduct; ?>

<?php $pageSize = 10; ?>
<?php $pageNumber = intval($count / $pageSize) + intval($count % $pageSize > 0); ?>
<?php $pageNumber = ($pageNumber > 0) ? $pageNumber : 1; ?>

<?php foreach (range(1, $pageNumber) as $num):*/ ?>
    <div style="width: 90%; padding-left: 30px">
        <div>
            <table>
                <tr>
                    <td style="font-weight: bold; width: 85%">
                        <p style="font-size: 18px;" ><?php echo CHtml::encode($branch->name); ?></p>
                        <p style="font-size: 12px;"><?php echo nl2br(CHtml::encode($branch->address)); ?></p>
                    </td>
                    <td style="float: right; text-align: right;">
                        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/' . CHtml::encode(CHtml::value($invoice, 'branch.filename')), CHtml::encode(CHtml::value($invoice, 'branch.filename')), array('style' => 'width: 200px; float: right; text-align: right;')); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <br />

    <div style="font-size: 20px; font-weight: bold; text-align: center">INVOICE</div>
    <div style="font-size: 14px; font-weight: bold; text-align: center"><?php echo CHtml::encode($invoice->number); ?></div>

    <br/>

    <div id="detail_div_memo">
        <div class="memonote">
            <div class="divtable">
                <div class="divtablecell hcolumn1">
                    <div class="divtable">
                        <table style="border-left:1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom:1px solid black">
                            <tr style="background-color:lightblue">
                                <td>Kepada Yth.</td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold"><?php echo CHtml::encode(CHtml::value($orderHeader, 'customer.company')); ?></td>
                            </tr>

                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($orderHeader, 'customer.address_1')); ?></td>
                            </tr>

                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($orderHeader, 'customer.city')); ?></td>
                            </tr>

                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($orderHeader, 'customer.tax_number')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="divtablecell hcolumn2">
                    <div class="divtable">
                        <table style="margin-left:50px; border-left:1px solid black;width: 83.5%; border-right: 1px solid black; border-top: 1px solid black; border-bottom:1px solid black">
                            <tr>
                                <td style="border-bottom:1px solid; background-color:lightblue; font-weight: bold">PO #</td>
                                <td style="border-bottom:1px solid"><?php echo CHtml::encode($orderHeader->reference_number); ?></td>
                            </tr>

                            <tr>
                                <td style="border-bottom:1px solid; background-color:lightblue; font-weight: bold">Tanggal</td>
                                <td style="border-bottom:1px solid">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d-MMM-yyyy', strtotime(CHtml::value($invoice, 'date')))); ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="border-bottom:1px solid; background-color:lightblue; font-weight: bold">Payment Term</td>
                                <td style="border-bottom:1px solid"><?php echo CHtml::encode($invoice->payment_term); ?> hari</td>
                            </tr>

                            <tr>
                                <td style="background-color:lightblue; font-weight: bold">Faktur Pajak #</td>
                                <td><?php echo CHtml::encode($invoice->tax_number); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <table class="memo">
            <tr id="theader">
                <th style="width: 5%">No</th>
                <th style="width: 10%">Quantity</th>
                <th style="width: 10%">Unit</th>
                <th>Nama Barang</th>
                <th style="width: 15%">Harga Unit (Rp)</th>
                <th style="width: 15%">Total (Rp)</th>
            </tr>
            <?php $counter = 1;?>
            <?php $invoiceDetails = $invoice->invoiceDetails; ?>
            <?php $invoiceNewProducts = $invoice->invoiceNewProducts; ?>

            <?php if (count($invoiceDetails) > 0): ?>
                <?php foreach ($invoiceDetails as $i => $detail): ?>
                    <?php $orderDetail = $detail->deliveryDetail->orderDetail; ?>
                    <tr class="titems">
                        <td style="text-align: center"><?php echo $counter; ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                        </td>
                        <td style="text-align: center;"><?php echo CHtml::encode(CHtml::value($orderDetail, 'unit.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($orderDetail, 'product_name')); ?></td>
                        <td style="text-align: right;">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'priceAfterDiscount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?>
                        </td>
                    </tr>
                    <?php $counter++; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (count($invoiceNewProducts) > 0): ?>
                <?php foreach ($invoiceNewProducts as $j => $detail): ?>
                        <?php $orderNewProduct = $detail->deliveryNewProduct->orderNewProduct; ?>
                        <tr class="titems">
                            <td style="text-align: center"><?php echo $counter; ?></td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                            </td>
                            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($orderNewProduct, 'unit.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($orderNewProduct, 'name')); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'priceAfterDiscount'))); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (count($invoiceDetails) > 0 || count($invoiceNewProducts) > 0): ?>
                <?php for ($j = 20, $counter = $counter % $j + 1; $j > $counter; $j--): ?>
                    <tr class="titems">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
                    
            <tr>
                <td style="border-top: 2px solid; border-left: 1px solid; border-right: 1px solid" colspan="4">Mohon ditransfer ke:</td>
                <td style="border-top: 1px solid; border-top: 2px solid; border-left: 1px solid; border-right: 1px solid; font-weight: bold; text-align: right">
                    <?php echo ($invoice->orderHeader->totalTax > 0) ? 'Sub Total' : ''; ?>
                </td>
                <td style="border-top: 1px solid; border-top: 2px solid; border-left: 1px solid; border-right: 1px solid; font-weight: bold; text-align: right">
                    <?php echo ($invoice->orderHeader->totalTax > 0) ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'subTotal'))) : ''; ?>
                </td>
            </tr>

            <tr>
                <td style="border-left: 1px solid; border-right: 1px solid" colspan="4">
                    <?php echo CHtml::encode(CHtml::value($invoice, 'branch.bank_account_name')); ?>
                </td>
                <td style ="border-left: 1px solid; border-right: 1px solid; font-weight: bold; text-align: right">
                    <?php echo ($invoice->orderHeader->totalTax > 0) ? 'PPN ' : ''; ?>
                </td>
                <td style="border-left: 1px solid; border-right: 1px solid; font-weight: bold; text-align: right">
                    <?php echo ($invoice->orderHeader->totalTax > 0) ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'totalTax'))) : ''; ?>
                </td>
            </tr>

            <tr>
                <td style="border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid;" colspan="4">
                    <?php echo CHtml::encode(CHtml::value($invoice, 'branch.bank_name')); ?> <br />
                    <?php echo CHtml::encode(CHtml::value($invoice, 'branch.bank_account_number')); ?>
                </td>
                <td style ="border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid; font-weight: bold; text-align: right">TOTAL</td>
                <td style="border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid; font-weight: bold; text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoice->grandTotal)); ?>
                </td>
            </tr>
        </table>

        <div style="background-color:lightblue; text-transform: capitalize">
            TERBILANG:
            <?php echo NumberWord::numberName(round(CHtml::encode(CHtml::value($invoice, 'grandTotal')), 0)); ?>
            rupiah
        </div>

        <br />

        <div class="memosig">
            <div class="divtable">
                <div style="text-align: left" class="divtablecell sig1">
                    <div>Perhatian:</div>
                    <div>* Barang yang sudah dibeli tidak dapat dikembalikan, kecuali dengan perjanjian</div>
                    <div>* Pembayaran dengan cheque/giro/wesel dianggap sah bila sudah diuangkan</div>
                </div>
                <div class="divtablecell sig2">
                    <table style="margin-left:200px; width:260px; border:1px solid black;">
                        <tr style="background-color:lightblue">
                            <td style="text-align:center; font-weight: bold">Hormat Kami,</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; height: 100px; vertical-align: bottom">
                                Finance Dept
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br /><br /><br /><br />
<?php //endforeach; ?>