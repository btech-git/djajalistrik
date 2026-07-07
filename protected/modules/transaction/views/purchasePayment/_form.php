<div class="form">

	<?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($purchasePayment->header); ?>
		<div class="container">
			<div class="span-12">
				<div class="row">
					<?php echo CHtml::label('Pembayaran #', false); ?>
					<?php echo CHtml::encode(CHtml::value($purchasePayment->header, 'number')); ?>
					<?php echo CHtml::error($purchasePayment->header, 'number'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::label('Tanggal', false); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model' => $purchasePayment->header,
						'attribute' => 'date',
						// additional javascript options for the date picker plugin
						'options' => array(
							'dateFormat' => 'yy-mm-dd',
						),
						'htmlOptions' => array(
							'readonly' => true,
						),
					)); ?>
					<?php echo CHtml::error($purchasePayment->header, 'date'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Catatan', false); ?>
					<?php echo CHtml::activeTextArea($purchasePayment->header, 'note'); ?>
					<?php echo CHtml::error($purchasePayment->header, 'note'); ?>
				</div>
			</div>
			
			<div class="span-12 last">
                <?php if ($purchasePayment->header->isNewRecord): ?>
                    <div class="row">
                        <?php echo CHtml::label('Tanda Terima Pembelian #', false); ?>
                        <?php echo CHtml::activeTextField($purchasePayment->header,'purchase_receipt_header_id', array('readonly'=>true, 'onclick'=>'$("#purchase-receipt-header-dialog").dialog("open"); return false;', 'onkeypress'=>'if (event.keyCode == 13) { $("#purchase-receipt-header-dialog").dialog("open"); return false; }')); ?>
                        <?php echo CHtml::openTag('span', array('id'=>'purchase_receipt_number')); ?>
                        <?php echo CHtml::encode(CHtml::value($purchasePayment->header,'purchaseReceiptHeader.number')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                        <?php echo CHtml::error($purchasePayment->header,'purchase_receipt_header_id'); ?>

                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id'=>'purchase-receipt-header-dialog',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                                'title'=>'Penerimaan Faktur',
                                'autoOpen'=>false,
                                'width'=>'auto',
                                'modal'=>true,
                            ),
                        )); ?>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'purchase-receipt-header-grid',
                            'dataProvider'=>$dataProvider,
                            'filter'=>$purchaseReceipt,
                            'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                            'selectionChanged'=>'js:function(id) {
                                $("#'.CHtml::activeId($purchasePayment->header, 'purchase_receipt_header_id').'").val($.fn.yiiGridView.getSelection(id));
                                $("#purchase-receipt-header-dialog").dialog("close");
                                if ($.fn.yiiGridView.getSelection(id) == "") {
                                    $("#purchase_number").html("");
                                    $("#purchase_date").html("");
                                    $("#purchase_supplier").html("");
                                    $("#grand_total").html("");
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "'.CController::createUrl('ajaxJsonPurchaseReceipt', array('id'=>$purchasePayment->header->id)).'",
                                        data: $("form").serialize(),
                                        success: function(data) {
                                            $("#purchase_number").html(data.purchase_number);
                                            $("#purchase_date").html(data.purchase_date);
                                            $("#purchase_supplier").html(data.purchase_supplier);
                                            $("#grand_total").html(data.grand_total);
                                        },
                                    });
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "'.CController::createUrl('ajaxHtmlResetPayment', array('id'=>$purchasePayment->header->id)).'",
                                    data: $("form").serialize(),
                                    success: function(html) { $("#detail_div").html(html); },
                                });
                            }',
                            'columns'=>array(
                                'number',
                                 array(
                                    'header' => 'Tanggal',
                                    'name' => 'date',
                                    'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                                ),
                                array(
                                    'header' => 'Perusahaan Supplier',
                                    'name' => 'supplier_id',
                                    'filter' => CHtml::listData(Supplier::model()->findAll(), 'id', 'company'),
                                    'value' => '$data->supplier->company',
                                ),
                                array(
                                    'header' => 'Total',
                                    'filter' => false,
                                    'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->grand_total)',
                                    'htmlOptions' => array(
                                        'style'=>'text-align: right',
                                    ),
                                ),
                                array(
                                    'header' => 'Payment',
                                    'filter' => false,
                                    'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->payment_total)',
                                    'htmlOptions' => array(
                                        'style'=>'text-align: right',
                                    ),
                                ),
                                array(
                                    'header' => 'Remaining',
                                    'filter' => false,
                                    'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->remaining)',
                                    'htmlOptions' => array(
                                        'style'=>'text-align: right',
                                    ),
                                ),
                            ),
                        )); ?>
                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                    </div>
                <?php endif; ?>
				
				<div class="row">
					<?php echo CHtml::activeLabelEx($purchasePayment->header,'Tanda Terima #'); ?>
					<?php echo CHtml::openTag('span', array('id'=>'purchase_number')); ?>
                        <?php echo CHtml::encode(CHtml::value($purchasePayment->header, 'purchaseReceiptHeader.number')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::activeLabelEx($purchasePayment->header,'Tanggal Pembelian'); ?>
					<?php echo CHtml::openTag('span', array('id'=>'purchase_date')); ?>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($purchasePayment->header, 'purchaseReceiptHeader.date'))); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<?php $purchaseHeader = $purchasePayment->header->purchaseReceiptHeader(array(
				'scopes' => 'resetScope',
				'with' => array(
					'supplier:resetScope',
					),
				)); ?>
				
				<div class="row">
					<?php echo CHtml::label('Supplier', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'purchase_supplier')); ?>
					<?php echo CHtml::encode(CHtml::value($purchaseHeader, 'supplier.company')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
			</div>
		</div>

		<hr />
		
		<div class="row buttons">
			<?php echo CHtml::button('Tambah Data Pembayaran', array(
				'onclick'=>CHtml::ajax(array(
					'type'=>'POST',
					'url'=>CController::createUrl('ajaxHtmlAddPayment', array('id'=>$purchasePayment->header->id)),
					'update'=>'#detail_div',
				)),
			)); ?>
        </div>
        
        <div id="detail_div">
            <?php $this->renderPartial('_detail', array('purchasePayment'=>$purchasePayment, 'error'=>$error)); ?>
        </div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
			<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
		</div>

	<?php echo CHtml::endForm(); ?>

</div><!-- form -->