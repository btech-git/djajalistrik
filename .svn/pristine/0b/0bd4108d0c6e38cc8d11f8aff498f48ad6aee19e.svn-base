<?php
Yii::app()->clientScript->registerScript('report', '
    $("#header").addClass("hide");
    $("#login").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    $("#body_left_column").addClass("hide");

    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $stockGlobalReport->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($stockGlobalReport->dataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div id="detail_div">
    <div class="hide">
        <div class="form" style="text-align: center">

            <?php echo CHtml::beginForm(array(''), 'get'); ?>

            <div class="row" style="background-color: #FFF8DC">
                Nama Produk
                <?php echo CHtml::activeTextField($product, 'name'); ?>
            </div>

            <div class="row">
                Jumlah per Halaman
                <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>

                Halaman saat ini
                <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
            </div>

            <div class="row">
                Tanggal Periode
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

        <div class="right"><?php echo ReportHelper::summaryText($stockGlobalReport->dataProvider); ?></div>
        <div class="clear"></div>
        <div class="right">
            <?php echo ReportHelper::sortText($stockGlobalReport->dataProvider->sort, array('Nama Produk', 'Kategori')); ?>
        </div>
        <div class="clear"></div>
    </div>

    <div>
        <?php $this->renderPartial('_report', array(
            'stockGlobalReport' => $stockGlobalReport,
            'endDate' => $endDate,
        )); ?>
    </div>

    <div class="hide">
        <div class="right">
            <?php
            $this->widget('system.web.widgets.pagers.CLinkPager', array(
                'itemCount' => $stockGlobalReport->dataProvider->pagination->itemCount,
                'pageSize' => $stockGlobalReport->dataProvider->pagination->pageSize,
                'currentPage' => $stockGlobalReport->dataProvider->pagination->getCurrentPage(false),
            ));
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>