<?php
$this->breadcrumbs = array(
	'Sale Receipt'=>array('customerList'),
	'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('sale-receipt-grid', {
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
    $.fn.yiiGridView.update('sale-receipt-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Kelola Data Tanda Terima Penjualan</h1>
<div id="detail_div">
	<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
	</p>
	<div id="link">
            <?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target' => '_blank', 'style' => 'display: none')); ?>
            <?php echo CHtml::link('Create', array('customerList')); ?>
	</div>

        <br />

        <?php echo CHtml::beginForm(); ?>
        <div>
            Page Size:
            <?php echo CHtml::dropDownList('PageSize', '', array(10 => '10', 25 => '25', 50 => '50', 100 => '100'), array(
                'onchange' => '$("form").submit();',
            )); ?> 

            Filter by Tanggal Kirim: 
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'SaleReceiptDeliveryDate',
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

            <?php echo CHtml::button('Reset', array('onclick' => '$("#InvoiceHeaderDate").val(""); $("form").submit();')); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'sale-receipt-grid',
		'dataProvider'=>$dataProvider,
		'filter'=>$saleReceipt,
		'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                'selectionChanged' => 'js:function(id) {
                    var url = "' . CController::createUrl('view') . '";
                    $("#ViewLink").attr("href", url + "&id=" + $.fn.yiiGridView.getSelection(id));
                    document.getElementById("ViewLink").click();
                }',
		'columns'=>array(
                    'number',
                    array(
                        'header' => 'Tanggal',
                        'name' => 'date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                    ),
                    array(
                        'header' => 'Tanggal Kirim',
                        'name' => 'delivery_date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->delivery_date)'
                    ),
                    array(
                        'name' => 'customer_id',
                        'filter' => CHtml::listData(Customer::model()->findAll(), 'id', 'name'),
                        'value' => '$data->customer->name',
                    ),
                    array(
                        'header' => 'Branch',
                        'name' => 'branch_id',
                        'filter' => CHtml::activeDropDownList($saleReceipt, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name ASC')), 'id', 'code'), array('empty' => '-- All --')),
                        'value' => '($data->branch_id === null ) ? "" : $data->branch->code',
                    ),
                    'note',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => $buttonTemplate,
                    ),
		),
	)); ?>
</div>
