<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Tanda Terima #', false); ?>
                <?php echo CHtml::encode(CHtml::value($saleReceipt->header, 'number')); ?>
                <?php echo CHtml::error($saleReceipt->header, 'number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $saleReceipt->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                ));
                ?>
                <?php echo CHtml::error($saleReceipt->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::activeLabelEx($saleReceipt->header, 'Cabang'); ?>
                <?php echo CHtml::activeDropDownList($saleReceipt->header, 'branch_id', CHtml::listData(Branch::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Branch --')) ?>
                <?php echo CHtml::error($saleReceipt->header, 'branch_id'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', false); ?>
                <?php echo CHtml::activeTextArea($saleReceipt->header, 'note', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($saleReceipt->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::encode(CHtml::value($customer, 'company')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Kirim', false); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $saleReceipt->header,
                    'attribute' => 'delivery_date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                ));
                ?>
                <?php echo CHtml::error($saleReceipt->header, 'delivery_date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Kirim', false); ?>
                <?php echo CHtml::activeTextArea($saleReceipt->header, 'delivery_address', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($saleReceipt->header, 'delivery_address'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row buttons">
        <?php echo CHtml::button('Tambah Invoice', array('name' => 'Search', 'onclick' => '$("#invoice-header-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#invoice-header-dialog").dialog("open"); return false; }')); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('saleReceipt' => $saleReceipt, 'error' => $error)); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'invoice-header-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-header-grid',
        'dataProvider' => $dataProvider,
        'filter' => $invoice,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            'number',
            array(
                'header' => 'F. Pajak',
                'filter' => false,
                'value' => '$data->tax_number',
            ),
            array(
                'header' => 'PO #',
                'filter' => false,
                'value' => '$data->orderHeader->reference_number',
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
            ),
            array(
                'header' => 'Customer',
                'filter' => CHtml::activeDropDownList($invoice, 'customer_id', CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '')),
                'value' => '$data->orderHeader->customer->name',
            ),
            array(
                'header' => 'Total',
                'filter' => false,
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->grand_total)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Payment',
                'filter' => false,
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->total_payment)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Remaining',
                'filter' => false,
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->remaining)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>
    
    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $saleReceipt->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#invoice-header-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>