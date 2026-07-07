<div class="form">

	<?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($quotation->header); ?>
		<div class="container">
			<div class="span-12">
				<div class="row">
					<?php echo CHtml::label('Quotation #', false); ?>
					<?php echo CHtml::encode(CHtml::value($quotation->header, 'number')); ?>
					<?php echo CHtml::error($quotation->header, 'number'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Tanggal', false); ?>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model' => $quotation->header,
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
					<?php echo CHtml::error($quotation->header, 'date'); ?>
				</div>
				
				<div class="row">
					 <?php echo CHtml::label('Catatan', ''); ?>
					 <?php echo CHtml::activeTextArea($quotation->header, 'note', array('cols' => '30', 'rows' => '5')); ?>
					 <?php echo CHtml::error($quotation->header, 'note'); ?>
				</div>
			</div>
			
			<div class="span-12 last">
				<div class="row">
					<?php echo CHtml::label('Customer', ''); ?>
					<?php echo CHtml::activeTextField($quotation->header,'customer_id', array('readonly'=>true, 'onclick'=>'$("#customer-dialog").dialog("open"); return false;', 'onkeypress'=>'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }')); ?>
					<?php echo CHtml::error($quotation->header,'customer_id'); ?>
                                
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
							$("#'.CHtml::activeId($quotation->header, 'customer_id').'").val($.fn.yiiGridView.getSelection(id));
							$("#customer-dialog").dialog("close");
							if ($.fn.yiiGridView.getSelection(id) == "")
							{
								$("#customer_id").html("");
								$("#customer_name").html("");
								$("#customer_company").html("");
								$("#customer_address_1").html("");
								$("#customer_city").html("");
								$("#customer_discount_category").html("");
							}
							else
							{
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "'.CController::createUrl('ajaxJsonCustomer', array('id'=>$quotation->header->id)).'",
									data: $("form").serialize(),
									success: function(data) {
										$("#customer_id").html(data.customer_id);
										$("#customer_name").html(data.customer_name);
										$("#customer_company").html(data.customer_company);
										$("#customer_address_1").html(data.customer_address_1);
										$("#customer_city").html(data.customer_city);
										$("#customer_discount_category").html(data.customer_discount_category);
									},
								});
							}
							$.ajax({
								type: "POST",
								url: "' . CController::createUrl('ajaxHtmlUpdateAllDiscount', array('id' => $quotation->header->id)) . '",
								data: $("form").serialize(),
								success: function(html) { $("#detail_div").html(html); },
							});
						}',
						'columns' => array(
							'name',
							'company',
							'address_1',
							'city',
						),
					));?>
					<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
				</div>
				
				<?php $quotationCustomer = $quotation->header->customer(array('scopes' => 'resetScope')); ?>
				
				<div class="row">
					<?php echo CHtml::label('Nama', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
					<?php echo CHtml::encode(CHtml::value($quotationCustomer, 'name')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Perusahaan', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
					<?php echo CHtml::encode(CHtml::value($quotationCustomer, 'company')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Alamat', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_address_1')); ?>
					<?php echo CHtml::encode(CHtml::value($quotationCustomer, 'address_1')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Kota', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_city')); ?>
					<?php echo CHtml::encode(CHtml::value($quotationCustomer, 'city')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Kategori Pelanggan', ''); ?>
					<?php echo CHtml::openTag('span', array('id' => 'customer_discount_category')); ?>
					<?php echo CHtml::encode(CHtml::value($quotationCustomer, 'discountCategory.name')); ?>
					<?php echo CHtml::closeTag('span'); ?>
				</div>
			
			</div>
		</div>
	
		<hr />
		<div class="row">
			<?php echo CHtml::button('Cari Barang', array('name'=>'Search', 
				'onclick'=>'$("#product-dialog").dialog("open"); return false;', 
				'onkeypress'=>'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }',
			)); ?>
			<?php echo CHtml::hiddenField('ProductId'); ?>
			
			<?php echo CHtml::button('Tambah Detail Kosong', array('name' => 'EmptyDetailAdd',
				'onclick' => CHtml::ajax(array(
					'type' => 'POST',
					'url' => CController::createUrl('ajaxHtmlAddEmptyDetail', array('id' => $quotation->header->id)),
					'update' => '#detail_div',
				)),
			));	?>
		</div>

		<div id="detail_div">
			<?php $this->renderPartial('_detail', array('quotation'=>$quotation, 'error'=>$error)); ?>
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
			'id' => 'product-dialog',
			// additional javascript options for the dialog plugin
			'options' => array(
				'title' => 'Products',
				'autoOpen' => false,
				'width' => 'auto',
				'modal' => true,
			),
		));
	?>

	<?php
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'product-grid',
			'dataProvider' => $dataProvider,
			'filter' => $product,
			'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
			'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
			'selectionChanged' => 'js:function(id) {
				$("#ProductId").val($.fn.yiiGridView.getSelection(id));
				$("#product-dialog").dialog("close");
				$.ajax({
					type: "POST",
					url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $quotation->header->id)) . '",
					data: $("form").serialize(),
					success: function(html) { $("#detail_div").html(html); },
				});
			}',
			'columns' => array(
				'code',
				'name',
				array(
					'name' => 'selling_price',
					'value' => 'number_format($data->selling_price, 2)',
					'htmlOptions' => array(
						'style'=>'text-align: right',
					),
				),
				array(
					'name' => 'quantity_bulk',
					'header' => 'Quantity',
					'value' => 'number_format($data->quantity_bulk, 0)',
					'htmlOptions' => array(
						'style'=>'text-align: right',
					),
				),
//				array(
//					'name' => 'product_category_id_single',
//					'header' => 'Category',
//					'filter' => CHtml::dropDownList('ProductCategoryMainId', $productCategoryMainId, CHtml::listData(ProductCategoryMain::model()->findAll(), 'id', 'name'), array('empty' => '')),	
//					'value' => '($data->productCategoryIdSingle->productCategoryMain === null) ? "N/A" : $data->productCategoryIdSingle->productCategoryMain->name',
//				),
//				array(
//					'name' => 'unit_id_single',
//					'header' => 'Satuan',
//					'filter' => CHtml::listData(Unit::model()->findAll(), 'id', 'name'),	
//					'value' => '($data->unitIdSingle === null) ? "" : $data->unitIdSingle->name',
//				),
			),
		));
	?>

	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>