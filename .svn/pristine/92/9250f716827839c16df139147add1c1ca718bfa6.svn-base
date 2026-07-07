<?php
CHtml::refresh(300);

$this->breadcrumbs = array(
    'Packing List' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('packing-list-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1>Packing List Admin</h1>

<div id="link">
    <?php echo CHtml::link('Create', array( 'create' ), array( 'target' => '_blank' )); ?>
    <?php echo CHtml::link('View', '#', array('id' => 'ViewLink', 'target' => '_blank', 'style' => 'display: none')); ?>
</div>

<br />

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>

    <div class="page-size-wrap">
        Page Size:
        <?php echo CHtml::dropDownList('PageSize', '', array(10 => '10', 25 => '25', 50 => '50', 100 => '100'), array(
            'onchange' => '$("form").submit();',
        )); ?>
    </div>
    
    <br/>
    
    Filter by Date: 
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'PackingListHeaderDate',
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

    <?php echo CHtml::button('Reset', array('onclick' => '$("#PackingListHeaderDate").val(""); $("form").submit();')); ?>
    
    
    <?php echo CHtml::endForm(); ?>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'packing-list-grid',
    'dataProvider' => $dataProvider,
    'filter' => $packingList,
    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
    'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
    'selectionChanged' => 'js:function(id) {
        var url = "' . CController::createUrl('view') . '";
        $("#ViewLink").attr("href", url + "&id=" + $.fn.yiiGridView.getSelection(id));
        document.getElementById("ViewLink").click();
    }',
    'columns' => array(
        array(
            'name' => 'number',
            'header' => 'Packing List #',
            'value' => '$data->number',
            'htmlOptions' => array('style' => 'width: 150px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'header' => 'PO Customer #',
            'filter' => CHtml::textField('OrderHeader', $orderHeader, array('size' => '10', 'maxLength' => '60')),
            'value' => 'CHtml::encode(CHtml::value($data, "orderHeader.reference_number"))',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::dropDownList('CustomerId', $customerId, CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => 'CHtml::encode(CHtml::value($data, "orderHeader.customer.name"))',
        ),
        array(
            'header' => 'Cabang',
            'name' => 'branch_id',
            'filter' => CHtml::listData(Branch::model()->findAll(), 'id', 'name'),
            'value' => 'CHtml::encode(CHtml::value($data, "branch.name"))',
        ),
        array(
            'header' => 'Gudang',
            'name' => 'warehouse_id',
            'filter' => CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'),
            'value' => 'CHtml::encode(CHtml::value($data, "warehouse.name"))',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
));
?>
