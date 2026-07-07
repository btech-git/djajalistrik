<?php
CHtml::refresh(300);

$this->breadcrumbs = array(
    'Pembelian' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('admin', "
    $('form').submit(function(){
        $.fn.yiiGridView.update('purchase-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php elseif (Yii::app()->user->hasFlash('failed')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('failed'); ?>
    </div>
<?php else: ?>
    <div></div>
<?php endif; ?>

<h1>Kelola Data Purchase Order</h1>

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
            'name' => 'Purchase Date',
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

        <?php echo CHtml::button('Semua Tanggal', array('onclick' => '$("#PurchaseHeaderDate").val(""); $("form").submit();')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>

    <div style="overflow: auto">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'purchase-grid',
            'dataProvider' => $dataProvider,
            'filter' => $purchase,
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
                    'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
                ),
                array(
                    'name' => 'supplier_id',
                    'filter' => CHtml::listData(Supplier::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                    'value' => '($data->supplier === null) ? "" : $data->supplier->company',
                ),
                array(
                    'name' => 'admin_id',
                    'header' => 'User',
                    'filter' => CHtml::listData(Admin::model()->findAll(), 'id', 'name'),
                    'value' => '($data->admin === null) ? "" : $data->admin->name',
                ),
                array(
                    'name' => 'customer_id',
                    'header' => 'Untuk Pelanggan',
                    'filter' => CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                    'value' => '($data->customer === null) ? "" : $data->customer->name',
                ),
                array(
                    'name' => 'branch_id',
                    'header' => 'Kantor Cabang',
                    'filter' => CHtml::listData(Branch::model()->findAll(), 'id', 'name'),
                    'value' => '($data->branch === null) ? "" : $data->branch->name',
                ),
                array(
                    'header' => 'PO Customer',
                    'filter' => CHtml::textField('OrderNumber', $orderNumber, array('size' => '10', 'maxLength' => '60')),
                    'value' => '($data->orderHeader === null ) ? "" : $data->orderHeader->reference_number',
                ),
                'note_internal',
                array(
                    'header' => 'Grand Total',
                    'value' => 'number_format($data->grandTotal, 0)',
                    'htmlOptions' => array(
                        'style' => 'text-align: right',
                    ),
                ),
                array(
                    'name' => 'is_approved',
                    'header' => 'Approval Status',
                    'filter' => array(PurchaseHeader::NOT_APPROVED => PurchaseHeader::NOT_APPROVED_LITERAL, PurchaseHeader::APPROVED => PurchaseHeader::APPROVED_LITERAL),
                    'value' => '$data->approvalStatus()',
                ),
                array(
                    'name' => 'is_inactive',
                    'header' => 'Status',
                    'filter' => array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => 'CANCELLED'),
                    'value' => '$data->activeStatus()',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => $buttonTemplate,
                ),
            ),
        )); ?>
    </div>
</div>
