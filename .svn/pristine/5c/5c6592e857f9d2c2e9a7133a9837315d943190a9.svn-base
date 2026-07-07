<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($purchaseReceipt->header); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Penerimaan Faktur #', false); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseReceipt->header, 'number')); ?>
                <?php echo CHtml::error($purchaseReceipt->header, 'number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $purchaseReceipt->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchaseReceipt->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', false); ?>
                <?php echo CHtml::activeTextArea($purchaseReceipt->header, 'note', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($purchaseReceipt->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::activeLabelEx($purchaseReceipt->header, 'Cabang'); ?>
                <?php echo CHtml::activeDropDownList($purchaseReceipt->header, 'branch_id', CHtml::listData(Branch::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Cabang --')) ?>
                <?php echo CHtml::error($purchaseReceipt->header, 'branch_id'); ?>
            </div>

            <?php if ($purchaseReceipt->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Supplier', ''); ?>
                    <?php echo CHtml::activeTextField($purchaseReceipt->header, 'supplier_id', array(
                        'readonly' => true, 
                        'onclick' => '$("#supplier-dialog").dialog("open"); return false;', 
                        'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }'
                    )); ?>
                    <?php echo CHtml::error($purchaseReceipt->header, 'supplier_id'); ?>

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
                        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
                        'selectionChanged' => 'js:function(id) {
                            $("#' . CHtml::activeId($purchaseReceipt->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#supplier-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                $("#supplier_id").html("");
                                $("#supplier_name").html("");
                                $("#supplier_company").html("");
                                $("#supplier_address").html("");
                                $("#supplier_city").html("");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $purchaseReceipt->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#supplier_id").html(data.supplier_id);
                                        $("#supplier_name").html(data.supplier_name);
                                        $("#supplier_company").html(data.supplier_company);
                                        $("#supplier_address").html(data.supplier_address);
                                        $("#supplier_city").html(data.supplier_city);
                                    },
                                });
                            }
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlResetDetail', array('id' => $purchaseReceipt->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                            $.fn.yiiGridView.update("receive-header-grid", {
                                data: $("form").serialize()
                            });
                        }',
                        'columns' => array(
                            'name',
                            'company',
                        ),
                    )); ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                </div>
            <?php endif; ?>

            <?php $purchaseReceiptSupplier = $purchaseReceipt->header->supplier(array('scopes' => 'resetScope')); ?>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseReceiptSupplier, 'name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseReceiptSupplier, 'company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Cari Purchase Order', array(
            'name' => 'Search', 
            'onclick' => '$("#receive-header-dialog").dialog("open"); return false;', 
            'onkeypress' => 'if (event.keyCode == 13) { $("#receive-header-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('ReceiveId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('purchaseReceipt' => $purchaseReceipt, 'error' => $error)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'receive-header-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Pembelian',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receive-header-grid',
        'dataProvider' => $dataProvider,
        'filter' => $receiveHeader,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
        'selectionChanged' => 'js:function(id) {
            $("#ReceiveId").val($.fn.yiiGridView.getSelection(id));
            $("#receive-header-dialog").dialog("close");
            $.ajax({
                type: "POST",
                url: "' . CController::createUrl('ajaxHtmlAddReceive', array('id' => $purchaseReceipt->header->id)) . '",
                data: $("form").serialize(),
                success: function(html) { $("#detail_div").html(html); },
            });
        }',
        'columns' => array(
            array(
                'header' => 'PO #',
                'filter' => CHtml::textField('PurchaseNumber', $purchaseNumber, array('size' => '10', 'maxLength' => '60')),
                'value' => '($data->purchaseHeader === null) ? "" : $data->purchaseHeader->number',
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
            ),
            array(
                'header' => 'Supplier',
                'name' => 'supplier_id',
                'filter' => false,
                'value' => '$data->purchaseHeader->supplier->name',
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->grandTotal, 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>