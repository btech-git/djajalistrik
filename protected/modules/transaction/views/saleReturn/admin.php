<?php
$this->breadcrumbs = array(
    'Retur Penjualan' => array('create'),
    'Manage',
);

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

<h1>Kelola Retur Penjualan Barang</h1>
<div id="detail_div">
    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
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
            'name' => 'SaleReturnHeaderDate',
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

        <?php echo CHtml::button('Reset', array('onclick' => '$("#SaleReturnHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>


    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sales-return-grid',
        'dataProvider' => $dataProvider,
        'filter' => $saleReturn,
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
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
            ),
            array(
                'header' => 'Customer',
                'filter' => CHtml::dropDownList('CustomerId', $customerId, CHtml::listData(Customer::model()->findAll(), 'id', 'name'), array('empty' => '')),
                'value' => '$data->deliveryHeader->orderHeader->customer->name',
            ),
            array(
                'header' => 'PO Customer',
                'filter' => CHtml::textField('OrderNumber', $orderNumber, array('size' => '10', 'maxLength' => '60')),
                'value' => '$data->deliveryHeader->orderHeader->reference_number',
            ),
            array(
                'name' => 'warehouse_id',
                'filter' => CHtml::listData(Warehouse::model()->findAll(), 'id', 'number'),
                'value' => '$data->warehouse->name',
            ),
            array(
                'name' => 'branch_id',
                'filter' => CHtml::listData(Branch::model()->findAll(), 'id', 'number'),
                'value' => '$data->branch->name',
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => $buttonTemplate,
            ),
        ),
    )); ?>
</div>
