<div class="form">
	<?php echo CHtml::beginForm(); ?>
		<div class="container">
			<div class="span-12">
				<div class="row">
					<?php echo CHtml::label('Penerimaan Faktur #', false); ?>
					<?php echo CHtml::encode(CHtml::value($receiptTemporary->header, 'number')); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'number'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::label('Tanggal', false); ?>
					<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model' => $receiptTemporary->header,
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
					<?php echo CHtml::error($receiptTemporary->header, 'date'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Jumlah Bayar', false); ?>
					<?php echo CHtml::activeTextField($receiptTemporary->header, 'amount'); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'amount'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::label('Metode Pembayaran', false); ?>
					<?php echo CHtml::activeDropDownList($receiptTemporary->header, 'is_cheque', array(ReceiptTemporaryHeader::CASH => ReceiptTemporaryHeader::CASH_LITERAL, ReceiptTemporaryHeader::CHEQUE => ReceiptTemporaryHeader::CHEQUE_LITERAL)); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'is_cheque'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::label('Nomor Giro', false); ?>
					<?php echo CHtml::activeTextField($receiptTemporary->header, 'cheque_number'); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'cheque_number'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Catatan', false); ?>
					<?php echo CHtml::activeTextArea($receiptTemporary->header, 'note'); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'note'); ?>
				</div>
			</div>
			
			<div class="span-12 last">
				<div class="row">
					<?php echo CHtml::label('Customer', ''); ?>
					<?php echo CHtml::activeTextField($receiptTemporary->header,'customer_id', array('readonly'=>true, 'onclick'=>'$("#customer-dialog").dialog("open"); return false;', 'onkeypress'=>'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }')); ?>
					<?php echo CHtml::error($receiptTemporary->header,'customer_id'); ?>
                                
					<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id'=>'customer-dialog',
						// additional javascript options for the dialog plugin
						'options'=>array(
							'title'=>'Customer',
							'autoOpen'=>false,
							'width'=>'auto',
							'modal'=>true,
						),
					)); ?>
					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'customer-grid',
						'dataProvider'=>$customer->search(),
						'filter'=>$customer,
						'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
						'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
						'selectionChanged'=>'js:function(id) {
							$("#'.CHtml::activeId($receiptTemporary->header, 'customer_id').'").val($.fn.yiiGridView.getSelection(id));
							$("#customer-dialog").dialog("close");
							if ($.fn.yiiGridView.getSelection(id) == "")
							{
								$("#customer_id").html("");
								$("#customer_name").html("");
								$("#customer_address").html("");
								$("#customer_city").html("");
								$("#customer_phone").html("");

							}
							else
							{
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "'.CController::createUrl('ajaxJsonCustomer', array('id'=>$receiptTemporary->header->id)).'",
									data: $("form").serialize(),
									success: function(data) {
										$("#customer_id").html(data.customer_id);
										$("#customer_name").html(data.customer_name);
										$("#customer_address").html(data.customer_address);
										$("#customer_city").html(data.customer_city);
										$("#customer_phone").html(data.customer_phone);
									},
								});
							}
							$.ajax({
								type: "POST",
								url: "'.CController::createUrl('ajaxHtmlResetDetail', array('id'=>$receiptTemporary->header->id)).'",
								data: $("form").serialize(),
								success: function(html) { $("#detail_div").html(html); },
							});
						}',
						'columns' => array(
							'name',
							'address_1',
							'city',
							'company_phone_1',
						),
					));?>
					<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
				</div>
				
				<?php $receiptTemporaryCustomer = $receiptTemporary->header->customer(array('scopes' => 'resetScope')); ?>
				
				<div class="row">
					<?php echo CHtml::label('Nama', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
					<?php echo CHtml::encode(CHtml::value($receiptTemporaryCustomer, 'name')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Alamat', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_address')); ?>
					<?php echo CHtml::encode(CHtml::value($receiptTemporaryCustomer, 'address')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Kota', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_city')); ?>
					<?php echo CHtml::encode(CHtml::value($receiptTemporaryCustomer, 'city')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Telpon', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_phone')); ?>
					<?php echo CHtml::encode(CHtml::value($receiptTemporaryCustomer, 'company_phone_1')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Status Barang', false); ?>
					<?php echo CHtml::activeDropDownList($receiptTemporary->header, 'is_item_ready', array(ReceiptTemporaryHeader::ITEM_NOT_READY => ReceiptTemporaryHeader::ITEM_NOT_READY_LITERAL, ReceiptTemporaryHeader::ITEM_PENDING => ReceiptTemporaryHeader::ITEM_PENDING_LITERAL, ReceiptTemporaryHeader::ITEM_READY => ReceiptTemporaryHeader::ITEM_READY_LITERAL)); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'is_item_ready'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::label('Metode Pembayaran', false); ?>
					<?php echo CHtml::activeDropDownList($receiptTemporary->header, 'is_delivery_ready', array(ReceiptTemporaryHeader::DELIVERY_NOT_READY => ReceiptTemporaryHeader::DELIVERY_NOT_READY_LITERAL, ReceiptTemporaryHeader::DELIVERY_READY => ReceiptTemporaryHeader::DELIVERY_READY_LITERAL)); ?>
					<?php echo CHtml::error($receiptTemporary->header, 'is_delivery_ready'); ?>
				</div>

			</div>
		</div>

		<hr />
		
		<div class="row">
			<?php echo CHtml::button('Cari Invoice', array('name'=>'Search', 'onclick'=>'$("#invoice-dialog").dialog("open"); return false;', 'onkeypress'=>'if (event.keyCode == 13) { $("#invoice-dialog").dialog("open"); return false; }')); ?>
			<?php echo CHtml::hiddenField('InvoiceTemporaryId'); ?>
		</div>

		<div id="detail_div">
			<?php $this->renderPartial('_detail', array('receiptTemporary'=>$receiptTemporary, 'error'=>$error)); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
			<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
		</div>

	<?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
	<?php
		$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id' => 'invoice-dialog',
			// additional javascript options for the dialog plugin
			'options' => array(
				'title' => 'Invoice',
				'autoOpen' => false,
				'width' => 'auto',
				'modal' => true,
			),
		));
	?>

	<?php
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'invoice-grid',
			'dataProvider' => $dataProvider,
			'filter' => $invoiceTemporary,
			'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
			'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
			'selectionChanged' => 'js:function(id) {
				$("#InvoiceTemporaryId").val($.fn.yiiGridView.getSelection(id));
				$("#invoice-dialog").dialog("close");
				$.ajax({
					type: "POST",
					url: "' . CController::createUrl('ajaxHtmlAddInvoiceTemporary', array('id' => $receiptTemporary->header->id)) . '",
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
					'header' => 'Jumlah',
					'name' => 'amount',
					'value' => 'number_format($data->amount, 2)',
					'filter' => false,
					'htmlOptions' => array('style'=>'text-align: right'),
				),
				array(
					'header' => 'Tanggal TT',
					'name' => 'date_receipt',
					'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date_receipt)'
				),
				array(
					'header' => 'Jumlah Bayar',
					'name' => 'amount_paid',
					'value' => 'number_format($data->amount_paid, 2)',
					'filter' => false,
					'htmlOptions' => array('style'=>'text-align: right'),
				),
				array(
					'header' => 'Tanggal Bayar',
					'name' => 'date_payment',
					'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date_payment)'
				),
				'paymentType.name',
				array(
					'header' => 'Customer',
					'name' => 'customer_id',
					'filter' => CHtml::listData(Customer::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
					'value' => '$data->customer->name',
				),
			),
		));
	?>

	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>