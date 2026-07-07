<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Penerimaan #', false); ?>
                <?php echo CHtml::encode(CHtml::value($receive->header, 'number')); ?>
                <?php echo CHtml::error($receive->header, 'number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $receive->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                ));
                ?>
                <?php echo CHtml::error($receive->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', false); ?>
                <?php echo CHtml::activeTextArea($receive->header, 'note', array('cols' => 30, 'rows' => 5)); ?>
                <?php echo CHtml::error($receive->header, 'note'); ?>
            </div>
        </div>

        <?php
        $receivePurchase = $receive->header->purchaseHeader(array(
            'scopes' => 'resetScope',
            'with' => array(
                'orderHeader:resetScope',
                'supplier:resetScope',
            ),
        ));
        ?>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Pembelian #', false); ?>
                <?php if ($receive->header->isNewRecord): ?>
                    <?php echo CHtml::activeTextField($receive->header, 'purchase_header_id', array('readonly' => true, 'onclick' => '$("#purchase-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'purchase_number')); ?>
                    <?php echo CHtml::encode(CHtml::value($receive->header, 'purchaseHeader.number')); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                    <?php echo CHtml::error($receive->header, 'purchase_header_id'); ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'purchase-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Pembelian',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    ));
                    ?>
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'purchase-grid',
                        'dataProvider' => $dataProvider,
                        'filter' => $purchase,
                        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
                        'selectionChanged' => 'js:function(id) {
								$("#' . CHtml::activeId($receive->header, 'purchase_header_id') . '").val($.fn.yiiGridView.getSelection(id));
								$("#purchase-dialog").dialog("close");
								if ($.fn.yiiGridView.getSelection(id) == "")
								{
									$("#purchase_number").html("");
									$("#order_header_id").html("");
									$("#supplier_company").html("");
									$("#supplier_name").html("");
								}
								else
								{
									$.ajax({
										type: "POST",
										dataType: "JSON",
										url: "' . CController::createUrl('ajaxJsonPurchase', array('id' => $receive->header->id)) . '",
										data: $("form").serialize(),
										success: function(data) {
											$("#purchase_number").html(data.purchase_number);
											$("#order_header_id").html(data.order_header_id);
											$("#supplier_company").html(data.supplier_company);
											$("#supplier_name").html(data.supplier_name);
										},
									});
								}
								$.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddPurchase', array('id' => $receive->header->id)) . '",
									data: $("form").serialize(),
									success: function(html) { $("#detail_div").html(html); },
								});
							}',
                        'columns' => array(
                            'number',
                            array(
                                'header' => 'Tanggal',
                                'name' => 'date',
                                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                            ),
                            array(
                                'header' => 'Perusahaan Supplier',
                                'name' => 'supplier_id',
                                'filter' => CHtml::listData(Supplier::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                                'value' => '$data->supplier->company',
                            ),
                            array(
                                'header' => 'PO Customer',
                                'filter' => CHtml::textField('OrderNumber', $orderNumber, array('size' => '10', 'maxLength' => '60')),
                                'value' => 'empty($data->order_header_id) ? "" : $data->orderHeader->reference_number',
                            ),
                            array(
                                'header' => 'Customer',
                                'filter' => CHtml::dropDownList('CustomerId', $customerId, CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- all --')),
                                'value' => 'empty($data->order_header_id) ? "" : $data->orderHeader->customer->name',
                            ),
                        ),
                    ));
                    ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                <?php else: ?>
                    <?php echo CHtml::encode(CHtml::value($receivePurchase, 'number')); ?>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Order', false); ?>
                <?php echo CHtml::openTag('span', array('id' => 'order_header_id')); ?>
                <?php echo CHtml::encode(CHtml::value($receivePurchase, 'orderHeader.reference_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan Supplier', false); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                <?php echo CHtml::encode(CHtml::value($receivePurchase, 'supplier.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
            <?php echo CHtml::label('Nama Supplier', false); ?>
            <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
            <?php echo CHtml::encode(CHtml::value($receivePurchase, 'supplier.name')); ?>
            <?php echo CHtml::closeTag('span'); ?>
            </div>

            <!--				<div class="row">
                <?php /* echo CHtml::label('Referensi', false); ?>
                  <?php echo CHtml::activeTextField($receive->header, 'reference'); ?>
                  <?php echo CHtml::error($receive->header, 'reference'); */ ?>
                                            </div>-->

            <div class="row">
<?php echo CHtml::label('Gudang', false); ?>
<?php echo CHtml::activeDropDownList($receive->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Gudang --')); ?>
<?php echo CHtml::error($receive->header, 'warehouse_id'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
<?php $this->renderPartial('_detail', array('receive' => $receive, 'error' => $error)); ?>
    </div>

    <div class="row buttons">
<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
    </div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->
