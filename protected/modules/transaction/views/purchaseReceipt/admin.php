<?php
$this->breadcrumbs = array(
    'Receipt' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('purchase-receipt-grid', {
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
	$.fn.yiiGridView.update('order-grid', {
            data: $(this).serialize()
	});
	return false;
    });
");
?>

<h1>Kelola Data Tanda Terima Pembelian</h1>
<div id="detail_div">
    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>
    
    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target' => '_blank', 'style' => 'display: none')); ?>
        <?php echo CHtml::link('Faktur Pajak Kosong', array('blankTaxNumber'), array('target' => '_blank', 'class' => 'right', 'style' => 'color: blue; font-weight: bold')); ?>
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
            'name' => 'PurchaseReceiptHeaderDate',
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

        <?php echo CHtml::button('Reset', array('onclick' => '$("#PurchaseReceiptHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-receipt-grid',
        'dataProvider' => $dataProvider,
        'filter' => $purchaseReceipt,
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
                'filter' => FALSE,
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
            ),
            array(
                'name' => 'supplier_id',
                'filter' => CHtml::listData(Supplier::model()->findAll(), 'id', 'name'),
                'value' => '$data->supplier->name',
            ),
            array(
                'name' => 'branch_id',
                'filter' => CHtml::listData(Branch::model()->findAll(), 'id', 'name'),
                'value' => '$data->branch->name',
            ),
            array(
                'name' => 'grand_total',
                'filter' => false,
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->grand_total)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => $buttonTemplate,
            ),
        ),
    )); ?>
</div>