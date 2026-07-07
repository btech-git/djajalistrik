<?php
CHtml::refresh(300);

$this->breadcrumbs = array(
    'Invoice' => array('create'),
    'Manage',
);

//Yii::app()->clientScript->registerScript('admin', "
//    $('form').submit(function(){
//        $.fn.yiiGridView.update('order-grid', {
//            data: $(this).serialize()
//        });
//        return false;
//    });
//");
?>

<h1>Data Outstanding Invoice</h1>
<div id="detail_div">
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

    <div id="link">
        <?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target' => '_blank', 'style' => 'display: none')); ?>
        <?php echo CHtml::link('Manage', array('admin'), array('target' => '_blank', 'style' => 'float: right')); ?>
    </div>

    <br /><br />

    <div>
        <!--Page Size:-->
        <?php /*echo CHtml::dropDownList('PageSize', '', array(
            10 => '10', 
            25 => '25', 
            50 => '50', 
            100 => '100'
        ), array('onchange' => '$("form").submit();',));*/ ?>

        Filter by Date: 
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'InvoiceHeaderDate',
            'value' => $invoiceHeaderDate,
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'onSelect' => 'js:function(dateText, inst) {
                    $("form").submit();
                }',
            ),
            'htmlOptions' => array('readonly' => true,),
        )); ?>

        <?php echo CHtml::button('Semua Tanggal', array('onclick' => '$("#InvoiceHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <br />

    <div style="overflow: auto">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-grid',
        'dataProvider' => $dataProvider,
        'filter' => $invoice,
        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'selectionChanged' => 'js:function(id) {
            var url = "' . CController::createUrl('view') . '";
            $("#ViewLink").attr("href", url + "&id=" + $.fn.yiiGridView.getSelection(id));
            document.getElementById("ViewLink").click();
        }',
//        'ajaxUpdate' => false,
        'columns' => array(
            'number',
//            array(
//                'header' => 'Branch',
//                'name' => 'branch_id',
//                'filter' => CHtml::activeDropDownList($invoice, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name ASC')), 'id', 'code'), array('empty' => '-- All --')),
//                'value' => '($data->branch_id === null ) ? "" : $data->branch->code',
//            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'filter' => FALSE,
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
            ),
            array(
                'header' => 'TOP (hari)',
                'value' => '($data->customer_id === null ) ? "" : $data->customer->payment_term',
            ),
            array(
                'header' => 'Customer',
                'filter' => CHtml::activeDropDownList($invoice, 'customer_id', CHtml::listData(Customer::model()->findAll(array(
                    'condition' => 't.is_inactive = 0',
                    'order' => 'company ASC'
                )), 'id', 'company'), array('empty' => '-- All --')),
                'value' => '($data->customer_id === null ) ? "" : $data->customer->company',
            ),
            array(
                'header' => 'PO Customer',
                'filter' => CHtml::textField('OrderNumber', $orderNumber, array('size' => '10', 'maxLength' => '60')),
                'value' => '($data->orderHeader === null ) ? "" : $data->orderHeader->reference_number',
            ),
            array(
                'name' => 'tax_number',
                'header' => 'F Pajak #',
                'value' => '$data->tax_number',
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->grand_total, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Payment',
                'value' => 'number_format($data->total_payment, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Remaining',
                'value' => 'number_format($data->remaining, 0)',
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
    <?php echo CHtml::endForm(); ?>
</div>
