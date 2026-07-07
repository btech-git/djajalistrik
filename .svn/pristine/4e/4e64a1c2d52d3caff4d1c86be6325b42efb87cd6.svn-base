<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($packingList->header); ?>
    
    <div class="container">
        <div class="span-11">
            <?php if ($packingList->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Packing List #', false); ?>
                    <?php echo CHtml::encode(CHtml::value($packingList->header, 'number')); ?>
                    <?php echo CHtml::error($packingList->header, 'number'); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $packingList->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($packingList->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($packingList->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($packingList->header, 'note'); ?>
            </div>
        </div>

        <div class="span-11 last">			
            <div class="row">
                <?php echo CHtml::label('S O #', false); ?>
                <?php if ($packingList->header->isNewRecord): ?>
                    <?php echo CHtml::activeTextField($packingList->header, 'order_header_id', array('readonly' => true, 'onclick' => '$("#order-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#order-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'order_number')); ?>
                    <?php echo CHtml::encode(CHtml::value($packingList->header, 'orderHeader.number')); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                    <?php echo CHtml::error($packingList->header, 'order_header_id'); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'order-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Sales Order',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>
                
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'order-grid',
                        'dataProvider' => $orderHeaderDataProvider,
                        'filter' => $orderHeader,
                        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                        'selectionChanged' => 'js:function(id) {
                            $("#' . CHtml::activeId($packingList->header, 'order_header_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#order-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                $("#order_number").html("");
                                $("#order_date").html("");
                                $("#order_admin").html("");
                                $("#customer_name").html("");
                                $("#customer_address_1").html("");
                                $("#reference_number").html("");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonOrder', array('id' => $packingList->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#order_number").html(data.order_number);
                                        $("#order_date").html(data.order_date);
                                        $("#order_admin").html(data.order_admin);
                                        $("#customer_name").html(data.customer_name);
                                        $("#customer_address_1").html(data.customer_address_1);
                                        $("#reference_number").html(data.reference_number);
                                    },
                                });
                            }
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $packingList->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                        }',
                        'columns' => array(
                            'number',
                            array(
                                'header' => 'Tanggal',
                                'name' => 'date',
                                'filter' => false,
                                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
                            ),
                            array(
                                'header' => 'Customer',
                                'name' => 'customer_id',
                                'filter' => CHtml::listData(Customer::model()->findAll(array('order' => 'company ASC')), 'id', 'company'),
                                'value' => '$data->customer->company',
                            ),
                            array(
                                'header' => 'PO Customer #',
                                'name' => 'reference_number',
                                'value' => '$data->reference_number',
                            ),
                            array(
                                'header' => 'Pembuat',
                                'name' => 'admin_id',
                                'filter' => false, //CHtml::listData(Admin::model()->findAll(), 'id', 'name'),
                                'value' => 'CHtml::encode(CHtml::value($data, "admin.name"))',
                            ),
                            array(
                                'header' => 'Branch',
                                'name' => 'branch_id',
                                'filter' => CHtml::listData(Branch::model()->findAll(), 'id', 'name'),
                                'value' => '$data->branch->name',
                            ),
                        ),
                    )); ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                <?php else: ?>
                    <?php echo CHtml::encode(CHtml::value($packingList->header->orderHeader, 'number')); ?>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal SO', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'order_date')); ?>
                <?php if ($packingList->header->orderHeader != NULL) : ?>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($packingList->header->orderHeader, 'date'))); ?>
                <?php endif; ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('PO Customer #', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'reference_number')); ?>
                <?php echo CHtml::encode(CHtml::value($packingList->header->orderHeader, 'reference_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama Customer', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($packingList->header->orderHeader, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address_1')); ?>
                <?php echo CHtml::encode(CHtml::value($packingList->header->orderHeader, 'customer.address_1')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Warehouse', FALSE); ?>
                <?php echo CHtml::activeDropDownList($packingList->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'), array(
                    'empty' => '-Select Warehouse-',
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id' => $packingList->header->id)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
<?php $this->renderPartial('_detail', array('packingList' => $packingList)); ?>
    </div>

    <div class="row buttons">
<?php
echo CHtml::submitButton('Submit', array(
    'name' => 'Submit',
    'confirm' => 'Are you sure you want to save?'
));
?>
    </div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->
