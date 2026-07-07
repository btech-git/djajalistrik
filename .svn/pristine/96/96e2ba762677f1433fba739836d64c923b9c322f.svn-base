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
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 50% }
    .sig2 { width: 50% }

');
?>
<div id="detail_div">
    <div id="memoheader">
        <div id="logo"><?php echo CHtml::image('images/logo.jpg', 'Djaja Listrik'); ?></div>
    </div>

    <br />

    <div class="memonote">
        <div class="divtable">
            <div class="divtablecell hcolumn1">
                <div class="divtable">
                    <table style="border-left:1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom:1px solid black">
                        <tr style="background-color:lightgray">
                            <td>Kepada Yth.</td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold"><?php echo CHtml::encode($invoice->customer->company); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo CHtml::encode($invoice->customer->address_1); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo CHtml::encode($invoice->customer->city); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="divtablecell hcolumn2">
                <div class="divtable">
                    <br/>
                    <div style="background-color:lightgray; margin-left:100px; width: 100%; font-size: 150%; font-weight: bold; text-align: center">INVOICE</div>
                    <br/>
                    <table style="margin-left:100px; border-left:1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom:1px solid black">
                        <tr>
                            <td style="border-bottom:1px solid; background-color:lightgray; font-weight: bold">Invoice No.</td>
                            <td style="border-bottom:1px solid"><?php echo CHtml::encode($invoice->number); ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid; background-color:lightgray; font-weight: bold">Tanggal</td>
                            <td style="border-bottom:1px solid"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d-MMM-yyyy', strtotime(CHtml::value($invoice, 'date')))); ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid; background-color:lightgray">Jumlah</td>
                            <td style="border-bottom:1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', round($invoice->amount, -2))); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br />

    <table class="memo">
        <tr>
            <td style="border-top: 2px solid; border-right: 1px solid" colspan="4"></td>
            <td style="border: 1px solid; border-top: 2px solid; font-weight: bold; text-align: right">Sub Total</td>
            <td style="border: 1px solid; border-top: 2px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'orderHeader.subTotal'))); ?></td>
        </tr>
        <tr>
            <td style="border-right: 1px solid" colspan="4">Mohon Ditransfer ke:</td>
            <td style ="border: 1px solid; font-weight: bold; text-align: right">PPN <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'tax'))); ?>%</td>
            <td style="border: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'calculatedTax'))); ?></td>
        </tr>
        <tr>
            <td style="border-right: 1px solid" colspan="4">PT. DJAJA LISTRIK</td>
            <td style ="border: 1px solid; font-weight: bold; text-align: right">Deposit</td>
            <td style="border: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'deposit'))); ?></td>
        </tr>
        <tr>
            <td style="border-right: 1px solid" colspan="4">Bank Mandiri Cab. Gunung Sahari</td>
            <td style ="border: 1px solid; font-weight: bold; text-align: right">Ongkos Kirim</td>
            <td style="border: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'shipping_fee'))); ?></td>
        </tr>
        <tr>
            <td style="border-right: 1px solid" colspan="4">119-00-0098879-8</td>
            <td style ="border: 1px solid; font-weight: bold; text-align: right">TOTAL</td>
            <td style="border: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', round($invoice->amount, -2))); ?></td>
        </tr>
    </table>

    <br />

    <div class="memosig">
        <div class="divtable">
            <div style="text-align: left" class="divtablecell sig1">
                <div>Perhatian:</div>
                <div>* Barang yang sudah dibeli tidak dapat</div>
                <div>dikembalikan, kecuali dengan perjanjian</div>
                <div>*Pembayaran dengan cheque/giro/wesel</div>
                <div>dianggap sah bila sudah diuangkan</div>
            </div>
            <div class="divtablecell sig2">
                <table style="margin-left:200px; width:260px; border:1px solid black;">
                    <tr style="background-color:lightgray">
                        <td style="text-align:center; font-weight: bold">Pembuat Invoice</td>
                    </tr>
                    <tr style="height: 100px">
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>