<h1>List Customer</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-grid',
    'dataProvider' => $customerDataProvider,
    'filter' => $customer,
    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
    'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
    'columns' => array(
        array(
            'name' => 'name',
            'value' => '$data->name',
        ),
        array(
            'name' => 'company',
            'value' => 'CHtml::value($data, "company")',
        ),
        'email',
        'tax_number',
        'contact_person',
        array(
            'name' => 'credit_limit',
            'value' => 'number_format(CHtml::value($data, "credit_limit"), 2)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'header' => 'Salesman',
            'value' => 'CHtml::value($data, "salesman.name")',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "customerId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>