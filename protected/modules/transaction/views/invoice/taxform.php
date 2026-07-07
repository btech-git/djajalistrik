<?php
Yii::app()->clientScript->registerScript('invoice', '
        $("#header").addClass("hide");
        $("#mainmenu").addClass("hide");
        $(".breadcrumbs").addClass("hide");
        $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/taxform.css');
Yii::app()->clientScript->registerCss('invoice', '
        .bordertopbottom
        {
			border-top: 1px solid;
			border-bottom: 1px solid;
        }
        
        .borderleftright
        {
			border-left: 1px solid;
			border-right: 1px solid;
        }
        
        .sig1 { width: 75% }
        .sig2 { width: 25% }
');
?>
<div id="detail_div">
    <div id="memoheader">
        <div class="divtable">
            <div class="divtablecell" style="width: 10%">&nbsp;</div>
            <div class="divtablecell" style="width: 55%">
                <div>&nbsp;</div>
                <div style="font-size: 24px">FAKTUR PAJAK</div>
            </div>
            <div class="divtablecell" style="width: 35%; text-align: left; font-size: 9px">
                <table style="border: 1px solid">
                    <tr>
                        <td style="vertical-align: top; width: 30%">Lembar Ke 1:</td>
                        <td style="width: 70%">Untuk Pembeli BKP/Penerima JKP sebagai bukti pajak Masukan</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">Lembar Ke 2:</td>
                        <td>Untuk PKP sebagai bukti pajak Keluaran</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">Lembar Ke 3:</td>
                        <td>Untuk Arsip/File</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <table class="formnote">
        <tr>
            <td style="width: 35%; font-weight: bold">Kode dan Nomor Seri Faktur Pajak</td>
            <td><?php echo CHtml::encode($invoice->id, 2); ?></td>
        </tr>
    </table>

    <table class="formnote">
        <caption style="font-weight: bold">Pengusaha Kena Pajak</caption>
        <tr>
            <td style="width: 25%">Nama</td>
            <td><?php echo CHtml::encode($invoice->branch->name); ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?php echo nl2br(CHtml::encode($invoice->branch->address)); ?></td>
        </tr>
        <tr>
            <td>NPWP</td>
            <td><?php echo CHtml::encode($invoice->branch->tax_number); ?></td>
        </tr>
    </table>

    <table class="formnote">
        <caption style="font-weight: bold">Pembeli Barang Kena Pajak / Penerima Jasa Kena Pajak</caption>
        <tr>
            <td style="width: 25%">Nama</td>
            <td><?php echo CHtml::encode(CHtml::value($invoice, 'deliveryHeader.orderHeader.customer.name')); ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?php echo CHtml::encode(CHtml::value($invoice, 'deliveryHeader.orderHeader.customer.address_1')); ?></td>
        </tr>
        <tr>
            <td>NPWP</td>
            <td><?php //echo CHtml::encode(CHtml::value($invoice, 'orderHeader.customer.npwp'));    ?></td>
        </tr>
    </table>

    <table class="memo formdetail">
        <tr id="theader" style="font-size: 12px">
            <th style="width: 0">No. Urut</th>
            <th>Nama Barang Kena Pajak / Jasa Kena Pajak</th>
            <th>Jumlah</th>
            <th style="width: 200px">Harga Jual/Penggantian/Uang Muka/Termin (Rp)</th>
        </tr>
        <?php $counter = 1; ?>
        <?php foreach ($invoice->deliveryHeader->deliveryDetails as $i => $detail): ?>
            <tr class="titems" style="font-size: 14px">
                <td><?php echo $counter; ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.product_name')); ?> <?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.product.size')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
            </tr>
            <?php $counter++; ?>
        <?php endforeach; ?>
        <?php foreach ($invoice->deliveryHeader->deliveryNewProducts as $i => $detail): ?>
            <tr class="titems" style="font-size: 14px">
               <td><?php echo $counter; ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'orderNewProduct.name')); ?> </td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
            </tr>
            <?php $counter++; ?>
        <?php endforeach; ?>    
        <?php for ($j = 20, $i = $i % $j + 1; $j > $i; $j--): ?>
            <tr class="titems">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php endfor; ?>
        <tr class="titems" style="font-size: 14px">
            <td class="formsummary" colspan="3">Harga Jual/Penggantian/Uang Muka/Termin *)</td>
            <td class="formsummary" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'deliveryHeader.subTotalAll'))); ?></td>
        </tr>
        <tr class="titems" style="font-size: 14px">
            <td class="formsummary" colspan="3">Dikurangi Total Potongan Harga</td>
            <td class="formsummary" style="text-align: right"><?php echo '0.00' //CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'orderHeader.deposit')));    ?></td>
        </tr>
        <tr class="titems" style="font-size: 14px">
            <td class="formsummary" colspan="3">Dikurangi Uang Muka yang telah diterima</td>
            <td class="formsummary" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'deliveryHeader.orderHeader.deposit'))); ?></td>
        </tr>
        <tr class="titems" style="font-size: 14px">
            <td class="formsummary" colspan="3">Dasar Pengenaan Pajak</td>
            <td class="formsummary" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'deliveryHeader.subTotalAll'))); ?></td>
        </tr>
        <tr class="titems" style="font-size: 14px">
            <td class="formsummary" colspan="3">PPN = 10 % X Dasar Pengenaan Pajak</td>
            <td class="formsummary" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'deliveryHeader.orderHeader.totalTax'))); ?></td>
        </tr>
    </table>

    <div class="divtable">
        <div class="divtablecell sig1" style="text-align: left; font-size: 14px">
            Pajak Penjualan Atas Barang Mewah
            <table style="width: 250px; border-spacing: 0pt; margin: 0">
                <tr>
                    <td class="bordertopbottom borderleftright" style="text-align: center; font-size: 11px">Tarif</td>
                    <td class="bordertopbottom" style="text-align: center; font-size: 11px">DPP</th>
                    <td class="bordertopbottom borderleftright" style="text-align: center; font-size: 11px">PPnBM</td>
                </tr>
                <tr>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">..........%</td>
                    <td style="text-align: center; font-size: 11px">Rp........</td>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">Rp........</td>
                </tr>
                <tr>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">..........%</td>
                    <td style="text-align: center; font-size: 11px">Rp........</td>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">Rp........</td>
                </tr>
                <tr>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">..........%</td>
                    <td style="text-align: center; font-size: 11px">Rp........</td>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">Rp........</td>
                </tr>
                <tr>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">..........%</td>
                    <td style="text-align: center; font-size: 11px">Rp........</td>
                    <td class="borderleftright" style="text-align: center; font-size: 11px">Rp........</td>
                </tr>
                <tr>
                    <td class="bordertopbottom borderleftright" style="font-size: 11px">Jumlah</td>
                    <td class="bordertopbottom" style="font-size: 11px"></td>
                    <td class="bordertopbottom borderleftright" style="font-size: 11px">Rp........</td>
                </tr>
            </table>
            *) Coret yang tidak perlu
        </div>
        <div class="divtablecell sig2">
            <div>&nbsp;</div>
            <div style="font-size: 14px">Jakarta, <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($invoice, 'deliveryHeader..orderHeader.date')))); ?></div>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <div style="text-decoration: underline; font-size: 14px"><?php echo CHtml::encode(CHtml::value($invoice, 'admin.name')); ?></div>
            <div style="font-size: 14px"><?php //echo CHtml::encode(CHtml::value($invoice, 'board.position'));    ?></div>
        </div>
    </div>
</div>