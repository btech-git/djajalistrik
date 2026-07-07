<table style="border: 1px solid">
    <tr style="background-color: #cd0a0a; color: white">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center">Jumlah</th>
        <th style="text-align: center">Satuan</th>
        <th style="text-align: center">Harga Satuan</th>
        <th style="text-align: center">+/-(%) 1</th>
        <th style="text-align: center">+/-(%) 2</th>
        <th style="text-align: center">+/-(%) 3</th>
        <th style="text-align: center">+/-(%) 4</th>
        <th style="text-align: center">+/-(%) 5</th>
        <th style="text-align: center">Unit Price</th>
        <th style="text-align: center">Total</th>
    </tr>
    <?php foreach ($invoice->details as $i => $detail): ?>

        <?php $orderDetail = $detail->deliveryDetail->orderDetail; ?>
        <tr style="background-color: #FFF8DC">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]delivery_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($orderDetail, 'product_name')); ?>
            </td>
            <td style="text-align: right; width: 10%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]quantity"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
            </td>
            <td style="width: 5%">
                <?php echo CHtml::encode(CHtml::value($orderDetail, 'unit.name')); ?>
            </td>
            <td style="text-align: right; width: 10%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?>
            </td>
            <td style="text-align: center; width: 5%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]discount_1"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_1'))); ?>
            </td>
            <td style="text-align: center; width: 5%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]discount_2"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_2'))); ?>
            </td>
            <td style="text-align: center; width: 5%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]discount_3"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_3'))); ?>
            </td>
            <td style="text-align: center; width: 5%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]discount_4"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_4'))); ?>
            </td>
            <td style="text-align: center; width: 5%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]discount_5"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_5'))); ?>
            </td>
            <td style="text-align: right; width: 10%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price_after_discount"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price_after_discount'))); ?>
            </td>
            <td style="text-align: right; width: 15%">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: #F5DEB3">
        <td colspan ="10" style="text-align: right">Sub Total:</td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoice->totalDetail)); ?>
        </td>
    </tr>
  
</table>
