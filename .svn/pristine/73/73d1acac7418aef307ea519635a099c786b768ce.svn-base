<?php
Yii::app()->clientScript->registerScript('report', '
    $("#header").addClass("hide");
    $("#login").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    $("#body_left_column").addClass("hide");

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $purchaseTaxReport->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($purchaseTaxReport->dataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<div id="detail_div">
    <div class="hide">
        <div class="form" style="text-align: center">

            <?php echo CHtml::beginForm(array(''), 'get'); ?>

            <div class="row" style="background-color: #FFF8DC">
                Supplier
                <?php echo CHtml::dropDownlist('SupplierId', $supplierId, CHtml::listData(Supplier::model()->active()->findAll(array('order' => 'company ASC')), 'id', 'name'), array('empty' => '-- Semua Supplier --')); ?>
            </div>

            <div class="row" style="background-color: #FFF8DC">
                Branch
                <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Semua Branch --')); ?>
            </div>

            <div class="row">
                Jumlah per Halaman
                <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>

                Halaman saat ini
                <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
            </div>

            <div class="row">
                Tanggal Mulai
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'StartDate',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>

                Sampai
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'EndDate',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
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

        <div class="right"><?php echo ReportHelper::summaryText($purchaseTaxReport->dataProvider); ?></div>
        <div class="clear"></div>
        <div class="right">
            <?php echo ReportHelper::sortText($purchaseTaxReport->dataProvider->sort, array('Tanggal', 'Penerimaan Faktur #')); ?>
        </div>
        <div class="clear"></div>
    </div>

    <div>
        <?php $this->renderPartial('_report', array(
            'purchaseTaxReport' => $purchaseTaxReport, 
            'startDate' => $startDate, 
            'endDate' => $endDate
        )); ?>
    </div>

    <div class="hide">
        <div class="right">
            <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
                'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                'itemCount' => $purchaseTaxReport->dataProvider->pagination->itemCount,
                'pageSize' => $purchaseTaxReport->dataProvider->pagination->pageSize,
                'currentPage' => $purchaseTaxReport->dataProvider->pagination->getCurrentPage(false),
            )); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>