<?php
$this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('sale-payment-grid', {
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

<h1>Kelola Data Pembayaran Penjualan</h1>
<div id="detail_div">
    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>
    
    <div id="link">
        <?php echo CHtml::link('Create', array('customerList')); ?>
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
            'name' => 'SalePaymentHeaderDate',
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

        <?php echo CHtml::button('Reset', array('onclick' => '$("#SalePaymentHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sale-payment-grid',
        'dataProvider' => $dataProvider,
        'filter' => $salePayment,
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
                'header' => 'Cabang',
                'name' => 'branch_id',
                'filter' => CHtml::activeDropDownList($salePayment, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '')),
                'value' => '$data->branch->name',
            ),
            array(
                'header' => 'Customer',
                'name' => 'customer_id',
                'filter' => CHtml::activeDropDownList($salePayment, 'customer_id', CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '')),
                'value' => '$data->customer->company',
            ),
            array(
                'header' => 'Total',
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->totalDetail)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => $buttonTemplate,
            ),
        ),
    )); ?>
</div>
