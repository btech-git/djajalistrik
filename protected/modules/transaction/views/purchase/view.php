<?php
$this->breadcrumbs = array(
    'Purchase' => array('/transaction/purchase/create'),
    'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $purchaseHeader,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'P O #',
                'value' => $purchaseHeader->number,
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseHeader->date),
            ),
            array(
                'label' => 'Customer PO #',
                'value' => ($orderHeader === null) ? '' : $orderHeader->reference_number,
            ),
            array(
                'label' => 'Untuk Customer',
                'value' => ($customer === null) ? 'N/A' : $customer->name,
            ),
            array(
                'label' => 'Supplier',
                'value' => $supplier->company,
            ),
            array(
                'label' => 'Currency',
                'value' => $currency->name,
            ),
            array(
                'label' => 'Branch',
                'value' => $branch->name,
            ),
            array(
                'label' => 'PPN / non-PPN',
                'value' => $purchaseHeader->taxStatus(),
            ),
            array(
                'label' => 'Include / Exclude',
                'value' => $purchaseHeader->includeTaxStatus(),
            ),
            array(
                'label' => 'Catatan Eksternal',
                'value' => $purchaseHeader->note_external,
            ),
            array(
                'label' => 'Catatan Internal',
                'value' => $purchaseHeader->note_internal,
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'product.name: Nama Barang',
            array(
                'header' => 'Jumlah Beli',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'unit.name: Satuan',
            array(
                'header' => 'Harga Satuan',
                'value' => 'number_format($data->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 1',
                'value' => 'number_format($data->discount_1, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 2',
                'value' => 'number_format($data->discount_2, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 3',
                'value' => 'number_format($data->discount_3, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 4',
                'value' => 'number_format($data->discount_4, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 5',
                'value' => 'number_format($data->discount_5, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->total, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-new-product-grid',
        'dataProvider' => $newProductsDataProvider,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'columns' => array(
            'product_name: Nama Barang',
            'brand.name: Brand',
            array(
                'header' => 'Jumlah Beli',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'unit.name: Satuan',
            array(
                'header' => 'Harga Satuan',
                'value' => 'number_format($data->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 1',
                'value' => 'number_format($data->discount_1, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 2',
                'value' => 'number_format($data->discount_2, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 3',
                'value' => 'number_format($data->discount_3, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 4',
                'value' => 'number_format($data->discount_4, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => '+/-(%) 5',
                'value' => 'number_format($data->discount_5, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->total, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $purchaseHeader,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'attributes' => array(
            array(
                'label' => 'Sub Total',
                'value' => number_format($purchaseHeader->subTotal, 2),
            ),
            array(
                'label' => 'PPN',
                'value' => number_format($purchaseHeader->totalTax, 2),
            ),
            array(
                'label' => 'Grand Total',
                'value' => number_format($purchaseHeader->grandTotal, 2),
            ),
        ),
    ));
    ?>

    <br /><br/>

    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('Update', array('update', 'id' => $purchaseHeader->id)); ?>

        <?php if ((int) $purchaseHeader->is_approved === 1): ?>
            <?php echo CHtml::link('Print', array('memo', 'id' => $purchaseHeader->id), array('target' => '_blank')); ?>
        <?php endif; ?><br /><br /><br />

        <?php echo CHtml::beginForm(); ?>
        <?php if (Yii::app()->user->checkAccess('administrator')): ?>
            <?php if ((int) $purchaseHeader->is_approved === 0): ?>
                <?php echo CHtml::submitButton('APPROVED', array('name' => 'Update', 'style' => 'background-color: lightgreen')); ?>
    <?php elseif ((int) $purchaseHeader->is_approved === 1): ?>
        <?php if ((int) $purchaseHeader->is_hold === 0): ?>
            <?php echo CHtml::submitButton('HOLD', array('name' => 'Hold', 'style' => 'background-color: red; font-weight: bold')); ?>
        <?php endif; ?>
        <?php echo CHtml::submitButton('CLEARED', array('name' => 'Cleared', 'style' => 'background-color: lightgreen; font-weight: bold')); ?>
        <?php echo CHtml::submitButton('CANCELED', array('name' => 'Canceled', 'style' => 'background-color: red; color:white; font-weight: bold')); ?>
    <?php endif; ?>
<?php endif; ?>
<?php echo CHtml::endForm(); ?>
    </div>
</div>