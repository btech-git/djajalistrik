<table>
    <tr style="background-color: #F5DEB3">
        <td colspan ="5" style="width: 15%; font-weight: bold; text-align: right"> Sub Total:</td>
        <td style="font-weight: bold; text-align: right">
            <span id="sub_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'subTotal'))); ?>
            </span>
        </td>
    </tr>
    
    <tr style="background-color: #F5DEB3">
        <td colspan ="5" style="width: 85%; text-align: right">PPN:</td>
        <td style="text-align: right">
            <span id="tax_value">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'totalTax'))); ?>
            </span>
        </td>
    </tr>
    
    <tr style="background-color: #F5DEB3">
        <td colspan ="5" style="width: 85%; text-align: right">Deposit:</td>
        <td style="text-align: right">
            <?php echo CHtml::activeHiddenField($invoice->header, 'deposit'); ?>
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice->header, 'deposit'))); ?>
        </td>
    </tr>
    
    <tr style="background-color: #F5DEB3">
        <td colspan ="5" style="width: 85%; text-align: right">Ongkos Kirim:</td>
        <td style="text-align: right">
            <?php echo CHtml::activeHiddenField($invoice->header, 'shipping_fee'); ?>
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice->header, 'shipping_fee'))); ?>
        </td>
    </tr>
    
    <tr style="background-color: #F5DEB3">
        <td colspan ="5" style="width: 85%; font-weight: bold; text-align: right">Grand Total:</td>
        <td style="font-weight: bold; text-align: right">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($invoice, 'grandTotal'))); ?>
            </span>
        </td>
    </tr>
</table>