<?php
CHtml::refresh(300);

$this->breadcrumbs = array(
    'Penerimaan' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('receive-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('receive-grid', {
                data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1>Kelola Surat Penerimaan Barang</h1>
<div id="detail_div">
    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

    <div id="link">
        <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
        <?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target' => '_blank', 'style' => 'display: none')); ?>
    </div>

    <br />

    <?php echo CHtml::beginForm(); ?>
    <div>
        Page Size:
        <?php echo CHtml::dropDownList('PageSize', '', array(10 => '10', 25 => '25', 50 => '50', 100 => '100'), array(
            'onchange' => '$("form").submit();',
        )); ?>

        Filter by Date: 
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'ReceiveHeaderDate',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'onSelect' => 'js:function(dateText, inst) {
                    $("form").submit();
                }',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>

        <?php echo CHtml::button('Reset', array('onclick' => '$("#ReceiveHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>

    <div style="overflow: auto">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'receive-grid',
            'dataProvider' => $dataProvider,
            'filter' => $receive,
            'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
            'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
            'selectionChanged' => 'js:function(id) {
                var url = "' . CController::createUrl('view') . '";
                $("#ViewLink").attr("href", url + "&id=" + $.fn.yiiGridView.getSelection(id));
                document.getElementById("ViewLink").click();
            }',
            'columns' => array(
                'number',
                array(
                    'header' => 'Tanggal',
                    'name' => 'date',
                    'filter' => false,
                    'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                ),
                array(
                    'name' => 'purchase_header_id',
                    'filter' => CHtml::textField('PurchaseNumber', $purchaseNumber, array('size' => '10', 'maxLength' => '60')),
                    'value' => '$data->purchaseHeader->number',
                ),
                array(
                    'header' => 'Supplier',
                    'filter' => CHtml::dropDownList('SupplierId', $supplierId, CHtml::listData(Supplier::model()->findAll(array('order' => 'company ASC')), 'id', 'company'), array('empty' => '-- all --')),
                    'value' => '$data->purchaseHeader->supplier->company',
                ),
                array(
                    'header' => 'PO Customer',
                    'name' => 'reference',
                    'value' => '$data->reference',
                ),
                array(
                    'header' => 'Customer',
                    'filter' => CHtml::dropDownList('CustomerId', $customerId, CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- all --')),
                    'value' => 'CHtml::encode(CHtml::value($data->purchaseHeader, "orderHeader.customer.name"))',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => $buttonTemplate,
                ),
            ),
        )); ?>
    </div>
</div>
