<?php
$this->breadcrumbs = array(
    'Stock' => array('/transaction/stock/check'),
    'Check',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div id="detail_div">
    <?php echo CHtml::beginForm('', 'get'); ?>

    <div class="search-form">
        <div class="row">
            <?php echo CHtml::label('Gudang', false); ?>
            <?php echo CHtml::dropDownList('WarehouseId', $warehouseId, CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'), array('empty' => '-- All --')); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activeLabel($product, 'Brand'); ?>
            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array('empty' => '-- All --')); ?>
        </div>

        <div class="row">
            <?php echo CHtml::activeLabel($product, 'Kode'); ?>
            <?php echo CHtml::activeTextField($product, 'code', array('size' => 60, 'maxlength' => 60)); ?>
        </div>

        <div class="row">
            <?php echo CHtml::activeLabel($product, 'Nama'); ?>
            <?php echo CHtml::activeTextField($product, 'name', array('size' => 60, 'maxlength' => 60)); ?>
        </div>

        <div class="row buttons" style="text-align: center">
            <?php echo CHtml::submitButton('Search'); ?>
        </div>
    </div>

    <?php echo CHtml::endForm(); ?>

    <div class="row">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'product-grid',
            'dataProvider' => $dataProvider,
            'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
            'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
            'columns' => array(
                'code',
                'name',
                array(
                    'name' => 'brand_id',
                    'filter' => CHtml::listData(Brand::model()->findAll(), 'id', 'name'),
                    'value' => '($data->brand === null) ? "" : $data->brand->name',
                ),
                array(
                    'header' => 'Total Stok',
                    'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->getTotalStock())',
                    'htmlOptions' => array(
                        'style' => 'text-align: right',
                    ),
                ),
                array(
                    'header' => 'Actual Stock',
                    'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->getStock(' . $warehouseId . '))',
                    'htmlOptions' => array(
                        'style' => 'text-align: right',
                    ),
                ),
            ),
        )); ?>
    </div>
</div>