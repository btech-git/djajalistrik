<?php
$this->breadcrumbs = array(
    'Adjustment' => array('admin'),
    'Create',
);
?>

<h1>Penyesuaian Stok Barang</h1>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Penyesuaian #', false); ?>
                <?php echo CHtml::encode(CHtml::value($adjustment->header, 'number')); ?>
                <?php echo CHtml::error($adjustment->header, 'number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $adjustment->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($adjustment->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Gudang', ''); ?>
                <?php echo CHtml::activeDropDownList($adjustment->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Gudang --',
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id' => $adjustment->header->id)),
                        'update' => '#detail_div',
                    )),
                )); ?>
                <?php echo CHtml::error($adjustment->header, 'warehouse_id'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Catatan', false); ?>
                <?php echo CHtml::activeTextArea($adjustment->header, 'note', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($adjustment->header, 'note'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
<?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
<?php echo CHtml::hiddenField('ProductId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('adjustment' => $adjustment, 'error' => $error)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->
<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'product-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Products',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'product-grid',
        'dataProvider' => $dataProvider,
        'filter' => $product,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
        'selectionChanged' => 'js:function(id) {
            $("#ProductId").val($.fn.yiiGridView.getSelection(id));
            $("#product-dialog").dialog("close");
            $.ajax({
                type: "POST",
                url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $adjustment->header->id)) . '",
                data: $("form").serialize(),
                success: function(html) { $("#detail_div").html(html); },
            });
        }',
        'columns' => array(
            'code',
            'name',
//            array(
//                'name' => 'selling_price',
//                'value' => 'number_format($data->selling_price, 2)',
//                'htmlOptions' => array(
//                    'style' => 'text-align: right',
//                ),
//            ),
//            array(
//                'name' => 'quantity_bulk',
//                'header' => 'Quantity',
//                'value' => 'number_format($data->quantity_bulk, 0)',
//                'htmlOptions' => array(
//                    'style' => 'text-align: right',
//                ),
//            ),
            array(
                'name' => 'product_category_id_single',
                'header' => 'Category',
//                'filter' => CHtml::dropDownList('ProductCategoryMainId', $productCategoryMainId, CHtml::listData(ProductCategoryMain::model()->findAll(), 'id', 'name'), array('empty' => '')),
                'value' => '($data->productCategoryIdSingle === null) ? "N/A" : $data->productCategoryIdSingle->name',
            ),
            array(
                'name' => 'unit_id_single',
                'header' => 'Satuan',
                'filter' => CHtml::listData(Unit::model()->findAll(), 'id', 'name'),
                'value' => '($data->unitIdSingle === null) ? "" : $data->unitIdSingle->name',
            ),
        ),
    )); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>
