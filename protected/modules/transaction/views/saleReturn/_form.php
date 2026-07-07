<div class="form">
	<?php echo CHtml::beginForm(); ?>
		<div class="container">
			<div class="span-12">
				<div class="row">
					<?php echo CHtml::label('Retur #', false); ?>
					<?php echo CHtml::encode(CHtml::value($saleReturn->header, 'number')); ?>
					<?php echo CHtml::error($saleReturn->header, 'number'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::label('Tanggal', false); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model' => $saleReturn->header,
						'attribute' => 'date',
						// additional javascript options for the date picker plugin
						'options' => array(
							'dateFormat' => 'yy-mm-dd',
						),
						'htmlOptions' => array(
							'readonly' => true,
						),
					)); ?>
					<?php echo CHtml::error($saleReturn->header, 'date'); ?>
				</div>
				<div class="row">
					<?php echo CHtml::label('Catatan', false); ?>
					<?php echo CHtml::activeTextArea($saleReturn->header, 'note', array('cols'=>'30', 'rows'=>'5')); ?>
					<?php echo CHtml::error($saleReturn->header, 'note'); ?>
				</div>
			</div>
			
			<div class="span-12 last">
				<div class="row">
					<?php echo CHtml::label('SJ #', false); ?>
					<?php if ($saleReturn->header->isNewRecord): ?>
						<?php echo CHtml::activeTextField($saleReturn->header,'delivery_header_id', array('readonly'=>true, 'onclick'=>'$("#delivery-dialog").dialog("open"); return false;', 'onkeypress'=>'if (event.keyCode == 13) { $("#delivery-dialog").dialog("open"); return false; }')); ?>
						<?php echo CHtml::openTag('span', array('id'=>'delivery_number')); ?>
						<?php echo CHtml::encode(CHtml::value($saleReturn->header,'deliveryHeader.number')); ?>
						<?php echo CHtml::closeTag('span'); ?>
						<?php echo CHtml::error($saleReturn->header,'delivery_header_id'); ?>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id'=>'delivery-dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
								'title'=>'Pengiriman',
								'autoOpen'=>false,
								'width'=>'auto',
								'modal'=>true,
							),
						)); ?>
						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'delivery-grid',
							'dataProvider'=>$dataProvider,
							'filter'=>$deliveryHeader,
							'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
							'selectionChanged'=>'js:function(id) {
								$("#'.CHtml::activeId($saleReturn->header, 'delivery_header_id').'").val($.fn.yiiGridView.getSelection(id));
								$("#delivery-dialog").dialog("close");
								if ($.fn.yiiGridView.getSelection(id) == "")
								{
									$("#order_number").html("");
									$("#customer_name").html("");
									$("#delivery_date").html("");
									$("#reference_number").html("");
								}
								else
								{
									$.ajax({
										type: "POST",
										dataType: "JSON",
										url: "'.CController::createUrl('ajaxJsonOrder', array('id'=>$saleReturn->header->id)).'",
										data: $("form").serialize(),
										success: function(data) {
											$("#order_number").html(data.order_number);
											$("#customer_name").html(data.customer_name);
											$("#delivery_date").html(data.delivery_date);
											$("#reference_number").html(data.reference_number);
										},
									});
								}
								$.ajax({
									type: "POST",
									url: "'.CController::createUrl('ajaxHtmlAddOrder', array('id'=>$saleReturn->header->id)).'",
									data: $("form").serialize(),
									success: function(html) { $("#detail_div").html(html); },
								});
								$.ajax({
									type: "POST",
									url: "'.CController::createUrl('ajaxHtmlAddNewProduct', array('id'=>$saleReturn->header->id)).'",
									data: $("form").serialize(),
									success: function(html) { $("#new_product_div").html(html); },
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
									'header' => 'PO Customer',
                                    'filter' => CHtml::textField('OrderNumber', $orderNumber, array('size' => '10', 'maxLength' => '60')),
                                    'value' => '$data->orderHeader->reference_number',
								),
								array(
									'header' => 'Nama Customer',
                                    'filter' => CHtml::dropDownList('CustomerId', $customerId, CHtml::listData(Customer::model()->findAll(), 'id', 'name'), array('empty'=>'')),
                                    'value' => '$data->orderHeader->customer->name',
								),
							),
						)); ?>
						<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
					<?php else: ?>
						<?php echo CHtml::encode(CHtml::value($saleReturn->header, 'deliveryHeader.number')); ?>
					<?php endif; ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Tanggal SJ', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'delivery_date')); ?>
					<?php echo CHtml::encode(CHtml::value($saleReturn->header, 'deliveryHeader.date')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Nama Customer', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
					<?php echo CHtml::encode(CHtml::value($saleReturn->header, 'deliveryHeader.orderHeader.customer.name')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('PO Customer', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'reference_number')); ?>
					<?php echo CHtml::encode(CHtml::value($saleReturn->header, 'deliveryHeader.orderHeader.reference_number')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Gudang', false); ?>
					<?php echo CHtml::activeDropDownList($saleReturn->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Warehouse --')); ?>
					<?php echo CHtml::error($saleReturn->header, 'warehouse_id'); ?>
				</div>
			</div>
		</div>

		<hr />

		<div id="detail_div">
			<?php $this->renderPartial('_detail', array('saleReturn' => $saleReturn, 'error' => $error)); ?>
		</div>

		<div id="new_product_div">
			<?php $this->renderPartial('_newProduct', array('saleReturn' => $saleReturn, 'error' => $error)); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
			<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
		</div>

	<?php echo CHtml::endForm(); ?>

</div><!-- form -->
