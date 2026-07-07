<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center; width: 15%">Invoice #</th>
        <th style="text-align: center; width: 10%">Jenis Pembayaran</th>
        <th style="text-align: center; width: 25%">Memo</th>
        <th style="text-align: center; width: 15%">Total Invoice</th>
        <th style="text-align: center; width: 15%">Jumlah Bayar</th>
        <th style="text-align: center; width: 15%">Biaya Lainnya</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($salePayment->details as $i => $detail): ?>
        <tr style="background-color: #FFF8DC">
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_header_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.number')); ?>
                <?php echo CHtml::error($detail, 'invoice_header_id'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]payment_type_id", CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
                <?php echo CHtml::error($detail, 'payment_type_id'); ?>
            </td>
            
            <td style="text-align: right">
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 30,)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
            
            <td style="text-align: right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]total_invoice"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_invoice'))); ?>
                <?php echo CHtml::error($detail, 'total_invoice'); ?>
            </td>
            
            <td style="text-align:right; width: 15%">
                <?php echo CHtml::activeTextField($detail, "[$i]amount", array(
                    'size' => 15,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonSummary', array('id' => $salePayment->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#amount_' . $i . '").html(data.amount);
                            $("#remaining").html(data.remaining);
                            $("#total_payment").html(data.total_payment);
                        }',
                    )),
                )); ?>
                <div id="amount_<?php echo $i; ?>" style="text-align: left; font-size: smaller">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'amount'); ?>
            </td>
            
            <td style="text-align:right; width: 15%">
                <?php echo CHtml::activeTextField($detail, "[$i]additional_amount", array(
                    'size' => 15,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonSummary', array('id' => $salePayment->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#additional_amount_' . $i . '").html(data.additional_amount);
                            $("#remaining").html(data.remaining);
                            $("#total_payment").html(data.total_payment);
                        }',
                    )),
                )); ?>
                <div id="additional_amount_<?php echo $i; ?>" style="text-align: left; font-size: smaller">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'additional_amount'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'additional_amount'); ?>
            </td>
            
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemovePayment', array('id' => $salePayment->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => 'Active', 
                        ActiveRecord::INACTIVE => 'Inactive'
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
        
    <tr style="background-color: #F5DEB3">
        <td style="font-weight: bold; text-align: right" colspan="5">Total Invoice:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'totalInvoice'))); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: #F5DEB3">
        <td style="font-weight: bold; text-align: right" colspan="5">Total Pembayaran:</td>
        <td style="text-align: right ; font-weight: bold">
            <span id="total_payment">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salePayment, 'totalPayment'))); ?>
            </span>
        </td>
        <td></td>
    </tr>

    <tr style="background-color: #F5DEB3">
        <td style="font-weight: bold; text-align: right" colspan="5">Sisa Pembayaran:</td>
        <td style="text-align: right ; font-weight: bold">
            <span id="remaining">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil(CHtml::value($salePayment, 'remaining')))); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>
