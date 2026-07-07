<?php Yii::app()->clientScript->registerScript('admin', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
'); ?>

<br />

<h1>Sales Order Belum Proses</h1>

<br /><br /><br />

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sale-grid',
        'dataProvider' => $dataProvider,
        'enablePagination' => false,
        'filter' => $orderHeader,
        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
//        'selectionChanged'=>'js:function(id) {
//            window.location.href = "' . CController::createUrl('view', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id);
//        }',
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->pagination->offset + $row+1', //  row is zero based
                'htmlOptions' => array(
                    'style' => 'text-align: right;'
                )
            ),
            array(
                'name' => 'number',
                'header' => 'Sales Order #',
                'value' => '$data->number',
                'htmlOptions' => array('style' => 'width: 200px'),
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
            ),
			array(
                'name' => 'customer_id',
                'filter' => CHtml::textField('CustomerName', $customerName),
                'value' => '$data->customer->name',
            ),
            array(
                'header' => 'PO Customer',
                'name' => 'reference_number',
                'value' => 'CHtml::encode(CHtml::value($data, "reference_number"))'
            ),
            array(
                'header' => 'Note External',
                'name' => 'note_external',
                'value' => 'CHtml::encode(CHtml::value($data, "note_external"))'
            ),
//            array(
//                'class' => 'CButtonColumn',
//                'template' => '{view}',
//                'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
//                'afterDelete' => 'function(){ location.reload(); }'
//            ),
        ),
    ));
    ?>

    <div class="row button link">
        <?php echo CHtml::link('List SO Sudah Proses', array('admin'), array('style' => 'float: left;')); ?>
        <?php echo CHtml::submitButton('Create Packing List', array('name' => 'PackList', 'style' => 'float: right;')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
</center>
