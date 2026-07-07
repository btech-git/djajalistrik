<?php
Yii::app()->clientScript->registerScript('report', '
    $("#header").addClass("hide");
    $("#login").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    $("#body_left_column").addClass("hide");

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $purchaseSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($purchaseSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                <?php echo CHtml::activeTextField($purchaseReceiptHeader, 'supplier_id', array(
                    'readonly' => true,
                    'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }'
                )); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'supplier-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Supplier',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'supplier-grid',
                    'dataProvider' => $supplierDataProvider,
                    'filter' => $supplier,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($purchaseReceiptHeader, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#supplier-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "")
                        {
                            $("#supplier_name").html("");
                            $("#supplier_code").html("");
                            $("#supplier_mobile_phone").html("");
                        }
                        else
                        {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $purchaseReceiptHeader->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#supplier_name").html(data.supplier_name);
                                    $("#supplier_code").html(data.supplier_code);
                                    $("#supplier_mobile_phone").html(data.supplier_mobile_phone);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        'name',
                        'company',
                        'address',
                        'email',
                        'phone',
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseReceiptHeader, 'supplier.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>    
            </div>

            <div class="row" style="background-color: #FFF8DC">
                Cabang
                  <?php echo CHtml::activeDropDownlist($purchaseReceiptHeader, 'branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('is_inactive'=>'0')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
            </div>

            <div class="row">
                Jumlah per Halaman
                <?php echo CHtml::textField('PageSize', '', array('size'=>3)); ?>

                Halaman saat ini
                <?php echo CHtml::textField('page', '', array('size'=>3, 'id'=>'CurrentPage')); ?>
            </div>

            <div class="row">
                Tanggal Mulai
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name'=>'StartDate',
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>

                Sampai
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name'=>'EndDate',
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
            </div>

            <div class="row">
                <?php echo CHtml::hiddenField('sort', '', array('id'=>'CurrentSort')); ?>
            </div>

            <div class="row button">
                <?php echo CHtml::submitButton('Show', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
                <?php echo CHtml::resetButton('Clear'); ?>
            </div>

            <br />
                           
            <div class="row">
                <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
            </div>

            <?php echo CHtml::endForm(); ?>

        </div>

        <hr />

        <div class="right"><?php echo ReportHelper::summaryText($purchaseSummary->dataProvider); ?></div>
        <div class="clear"></div>
        <div class="right"><?php echo ReportHelper::sortText($purchaseSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
        <div class="clear"></div>

        <div>
            <?php $this->renderPartial('_summary', array(
                'purchaseSummary' => $purchaseSummary, 
                'startDate' => $startDate, 
                'endDate' => $endDate
            )); ?>
        </div>

        <div class="right">
            <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
                'itemCount' => $purchaseSummary->dataProvider->pagination->itemCount,
                'pageSize' => $purchaseSummary->dataProvider->pagination->pageSize,
                'currentPage' => $purchaseSummary->dataProvider->pagination->getCurrentPage(false),
            ));*/ ?>
        </div>
        <div class="clear"></div>
    </div>
</div>