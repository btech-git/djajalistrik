<?php
CHtml::refresh(300);

$this->breadcrumbs = array(
    'Adjustment' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('adjustment-grid', {
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
        $.fn.yiiGridView.update('adjustment-grid', {
                data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1>Kelola Data Stok Adjustment</h1>
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
            'name' => 'AdjustmentHeaderDate',
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

        <?php echo CHtml::button('Reset', array('onclick' => '$("#AdjustmentHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
    
    <div style="overflow: auto">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'adjustment-grid',
            'dataProvider' => $dataProvider,
            'filter' => $adjustmentHeader,
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
                    'name' => 'warehouse_id',
                    'filter' => CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'),
                    'value' => '$data->warehouse->name',
                ),
                array(
                    'name' => 'branch_id',
                    'filter' => CHtml::listData(Branch::model()->findAll(), 'id', 'name'),
                    'value' => '$data->branch->name',
                ),
                'note',
                array(
                    'class' => 'CButtonColumn',
                    'template' => $buttonTemplate,
                ),
            ),
        )); ?>
    </div>
</div>