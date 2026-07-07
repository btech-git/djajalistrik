<div class="form">

	<?php echo CHtml::beginForm(); ?>
	
		<div class="container">
			<div class="span-12">
				<div class="row">
					<?php echo CHtml::label('Retur #', false); ?>
					<?php echo CHtml::encode(CHtml::value($purchaseReturn->header, 'number')); ?>
					<?php echo CHtml::error($purchaseReturn->header, 'number'); ?>
				</div>
				<div class="row">
					<?php echo CHtml::label('Tanggal', false); ?>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model' => $purchaseReturn->header,
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
					<?php echo CHtml::error($purchaseReturn->header, 'date'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Catatan', false); ?>
					<?php echo CHtml::activeTextArea($purchaseReturn->header, 'note', array('cols'=>'30', 'rows'=>'5')); ?>
					<?php echo CHtml::error($purchaseReturn->header, 'note'); ?>
				</div>
			</div>
			
			<?php $returnReceive = $purchaseReturn->header->receiveHeader(array(
				'scopes' => 'resetScope',
				'with' => array(
					'purchaseHeader:resetScope' => array(
						'with' => 'supplier:resetScope',
					),
				),
			)); ?>
			
			<div class="span-12 last">
				<div class="row">
					<?php echo CHtml::label('Penerimaan #', false); ?>
					<?php if ($purchaseReturn->header->isNewRecord): ?>
						<?php echo CHtml::activeTextField($purchaseReturn->header,'receive_header_id', array('readonly'=>true, 'onclick'=>'$("#receive-header-dialog").dialog("open"); return false;', 'onkeypress'=>'if (event.keyCode == 13) { $("#receive-header-dialog").dialog("open"); return false; }')); ?>
						<?php echo CHtml::openTag('span', array('id'=>'receive_header_number')); ?>
						<?php echo CHtml::encode(CHtml::value($purchaseReturn->header,'receiveHeader.number')); ?>
						<?php echo CHtml::closeTag('span'); ?>
						<?php echo CHtml::error($purchaseReturn->header,'receive_header_id'); ?>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id'=>'receive-header-dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
								'title'=>'Items Received',
								'autoOpen'=>false,
								'width'=>'auto',
								'modal'=>true,
							),
						)); ?>
						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'receive-header-grid',
							'dataProvider'=>$dataProvider,
							'filter'=>$receiveHeader,
							'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
							'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
							'selectionChanged'=>'js:function(id) {
								$("#'.CHtml::activeId($purchaseReturn->header, 'receive_header_id').'").val($.fn.yiiGridView.getSelection(id));
								$("#receive-header-dialog").dialog("close");
								if ($.fn.yiiGridView.getSelection(id) == "")
								{
									$("#receive_header_number").html("");
									$("#supplier_name").html("");
									$("#supplier_company").html("");
									$("#supplier_address").html("");
								}
								else
								{
									$.ajax({
										type: "POST",
										dataType: "JSON",
										url: "'.CController::createUrl('ajaxJsonReceive', array('id'=>$purchaseReturn->header->id)).'",
										data: $("form").serialize(),
										success: function(data) {
											$("#receive_header_number").html(data.receive_header_number);
											$("#supplier_name").html(data.supplier_name);
											$("#supplier_company").html(data.supplier_company);
											$("#supplier_address").html(data.supplier_address);
										},
									});
								}
								$.ajax({
									type: "POST",
									url: "'.CController::createUrl('ajaxHtmlAddProduct', array('id'=>$purchaseReturn->header->id)).'",
									data: $("form").serialize(),
									success: function(html) { $("#detail_div").html(html); },
								});
								$.ajax({
									type: "POST",
									url: "'.CController::createUrl('ajaxHtmlAddNewProduct', array('id'=>$purchaseReturn->header->id)).'",
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
									'header' => 'PO #',
									'name' => 'purchase_header_id',
                                    'filter' => CHtml::textField('PurchaseNumber', $purchaseNumber, array('size' => '10', 'maxLength' => '60')),
									'value' => '$data->purchaseHeader->number',
								),
								array(
									'header' => 'Supplier',
									'name' => 'purchaseHeader.supplier.company',
                                    'filter' => CHtml::dropDownList('SupplierID', $supplierId, CHtml::listData(Supplier::model()->findAll(array('order' => 'company ASC')), 'id', 'company'), array('empty' => '-- all --')),
									'value' => '$data->purchaseHeader->supplier->company',
								),
							),
						)); ?>
						<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
					<?php else: ?>
						<?php echo CHtml::activeHiddenField($purchaseReturn->header,'receive_header_id'); ?>
						<?php echo CHtml::encode(CHtml::value($returnReceive, 'number')); ?>
					<?php endif; ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Supplier', false); ?>
					<?php echo CHtml::openTag('span', array('id'=>'supplier_name')); ?>
					<?php echo CHtml::encode(CHtml::value($returnReceive, 'purchaseHeader.supplier.name')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Perusahaan', false); ?>
					<?php echo CHtml::openTag('span', array('id'=>'supplier_company')); ?>
					<?php echo CHtml::encode(CHtml::value($returnReceive, 'purchaseHeader.supplier.company')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Alamat', false); ?>
					<?php echo CHtml::openTag('span', array('id'=>'supplier_address')); ?>
					<?php echo CHtml::encode(CHtml::value($returnReceive, 'purchaseHeader.supplier.address')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Gudang', false); ?>
					<?php echo CHtml::activeDropDownList($purchaseReturn->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Gudang --')); ?>
					<?php echo CHtml::error($purchaseReturn->header, 'warehouse_id'); ?>
				</div>
			</div>
		</div>

		<hr />

		<div id="detail_div">
			<?php $this->renderPartial('_detail', array('purchaseReturn' => $purchaseReturn, 'error' => $error)); ?>
		</div>

		<div id="new_product_div">
			<?php $this->renderPartial('_newProduct', array('purchaseReturn' => $purchaseReturn, 'error' => $error)); ?>
		</div>
        
        <div>
            <table>
                <tr style="background-color: #F5DEB3">
                    <td>&nbsp;</td>
                    <?php if (!empty($purchaseReturn->header->receive_header_id) && $purchaseReturn->header->isNewRecord): ?>
                        <td>&nbsp;</td>
                    <?php endif; ?>
                    <td style="text-align: right; font-weight: bold" colspan="2">Grand Total:</td>
                    <td style="text-align: right; font-weight: bold">
                        <span id="grand_total">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($grandTotal = $purchaseReturn->getGrandTotal($purchaseReturn->header->receive_header_id)) > 1000000 ? round($grandTotal, -3) : round($grandTotal, -2))); ?>
                        </span>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
			<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
		</div>

	<?php echo CHtml::endForm(); ?>

</div><!-- form -->
