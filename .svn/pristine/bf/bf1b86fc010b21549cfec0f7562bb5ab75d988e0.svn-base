<div class="form">
	<?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($delivery->header); ?>
    <?php echo CHtml::errorSummary($delivery->details); ?>
    <div>
        <div class="span-11">
            <?php if (!$delivery->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Pengiriman #', false); ?>
                    <?php echo CHtml::encode(CHtml::value($delivery->header, 'number')); ?>
                    <?php echo CHtml::error($delivery->header, 'number'); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $delivery->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($delivery->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Gudang', false); ?>
                <?php echo CHtml::activeDropDownList($delivery->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'),array('empty' => '-- Pilih Gudang --', 
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id'=>$delivery->header->id)),
                        'update' => '#detail_div',
                    )),
                )); ?>
                <?php echo CHtml::error($delivery->header, 'warehouse_id'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Catatan External', false); ?>
                <?php echo CHtml::activeTextArea($delivery->header, 'note', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($delivery->header, 'note'); ?>
            </div>
        </div>

        <div class="span-11 last">
            <div class="row">
                <?php echo CHtml::label('Sales Order #', false); ?>
                <?php echo CHtml::activeHiddenField($delivery->header, 'order_header_id'); ?>
                <?php echo CHtml::encode(CHtml::value($orderHeader, 'number')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal', ''); ?>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($orderHeader,'date'))); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('PO Customer #', ''); ?>
                <?php echo CHtml::encode(CHtml::value($orderHeader ,'reference_number')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama Customer', ''); ?>
                <?php echo CHtml::encode(CHtml::value($orderHeader, 'customer.name')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::encode(CHtml::value($orderHeader, 'customer.address_1')); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Pembuat', ''); ?>
                <?php echo CHtml::encode(CHtml::value($orderHeader, 'admin.name')); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Catatan Internal', false); ?>
                <?php echo CHtml::activeTextArea($delivery->header, 'note_internal', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($delivery->header, 'note_internal'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Item Stok', array('name' => 'Search', 'onclick' => '$("#packing-list-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#packing-list-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::button('Tambah Item Non-Stok', array('name' => 'Search', 'onclick' => '$("#receive-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#receive-dialog").dialog("open"); return false; }')); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('delivery' => $delivery)); ?>
    </div>

    <div id="detail_new_product">
        <?php $this->renderPartial('_newProduct', array('delivery' => $delivery)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
    </div>

	<?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'packing-list-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Packing List',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'packing-list-grid',
        'dataProvider' => $packingListDetailDataProvider,
        'filter' => $packingListDetail,
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'header' => 'Packing List #',
                'value' => '$data->packingListHeader->number',
                'htmlOptions' => array('style' => 'width: 200px'),
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->packingListHeader->date)'
            ),
            'orderDetail.product_name: Product',
            'quantity',
            'orderDetail.unit.name: Satuan',
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Packing List', CController::createUrl('ajaxHtmlAddPackingLists', array('id' => $delivery->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#packing-list-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'receive-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Penerimaan',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receive-grid',
        'dataProvider' => $orderNewProductDataProvider,
        'filter' => $orderNewProduct,
        'columns' => array(
            array(
                'id' => 'selectedReceiveIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'header' => 'SO #',
                'value' => '$data->orderHeader->number',
                'htmlOptions' => array('style' => 'width: 200px'),
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->orderHeader->date)'
            ),
            'name: Product',
            'quantity',
            'quantity_receive_remaining: Qty Terima',
            'unit.name: Satuan',
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Order', CController::createUrl('ajaxHtmlAddReceives', array('id' => $delivery->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_new_product").html(html);
            $("#receive-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>