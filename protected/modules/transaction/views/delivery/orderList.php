<h1>List Sales Order</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'order-grid',
    'dataProvider' => $orderHeaderDataProvider,
    'filter' => $orderHeader,
    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
    'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
    'columns' => array(
        array(
            'name' => 'number',
            'header' => 'SO #',
            'value' => '$data->number',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)',
        ),
        array(
            'header' => 'PO Customer',
            'name' => 'reference_number',
            'value' => 'CHtml::value($data, "reference_number")',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "customer.company")',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "orderHeaderId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>