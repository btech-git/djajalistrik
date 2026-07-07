<?php
Yii::app()->clientScript->registerScript('report', '
    $("#header").addClass("hide");
    $("#login").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    $("#body_left_column").addClass("hide");

');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<div id="detail_div">
    <div class="hide">
        <div class="form" style="text-align: center">

            <?php echo CHtml::beginForm(array(''), 'get'); ?>

            <div class="row" style="background-color: #FFF8DC">
                Periode
                <?php echo CHtml::dropDownList('Month', $month, array(
                    '01' => 'Jan',
                    '02' => 'Feb',
                    '03' => 'Mar',
                    '04' => 'Apr',
                    '05' => 'May',
                    '06' => 'Jun',
                    '07' => 'Jul',
                    '08' => 'Aug',
                    '09' => 'Sep',
                    '10' => 'Oct',
                    '11' => 'Nov',
                    '12' => 'Dec',
                )); ?>
                <?php echo CHtml::dropDownList('Year', $year, $yearList); ?>
            </div>

            <div class="row">
                <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
            </div>

            <div class="row button">
                <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                <?php echo CHtml::resetButton('Clear'); ?>
            </div>

            <?php echo CHtml::endForm(); ?>

        </div>

        <hr />

        <div class="clear"></div>
    </div>

    <div>
        <?php $this->renderPartial('_summary', array(
            'monthlyUserSaleReport' => $monthlyUserSaleReport,
            'monthlyUserSaleReceiptReport' => $monthlyUserSaleReceiptReport,
            'monthlyUserSalePaymentReport' => $monthlyUserSalePaymentReport,
            'monthlyUserDeliveryReport' => $monthlyUserDeliveryReport,
            'monthlyUserSaleOrderReport' => $monthlyUserSaleOrderReport,
            'monthlyUserPurchaseReceiptReport' => $monthlyUserPurchaseReceiptReport,
            'monthlyUserPurchasePaymentReport' => $monthlyUserPurchasePaymentReport,
            'monthlyUserReceiveReport' => $monthlyUserReceiveReport,
            'monthlyUserPackingListReport' => $monthlyUserPackingListReport,
            'monthlyUserPurchaseReport' => $monthlyUserPurchaseReport,
            'year' => $year,
            'month' => $month,
        )); ?>
    </div>
</div>