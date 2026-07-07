<div class="form">

	<?php echo CHtml::beginForm(); ?>
	<div class="container">
			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'volume'); ?>
				<?php echo CHtml::activeTextField($model, 'volume'); ?>
				<?php echo CHtml::error($model, 'volume'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'selling_price'); ?>
				<?php echo CHtml::activeTextField($model, 'selling_price'); ?>
				<?php echo CHtml::error($model, 'selling_price'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'quantity_minimum'); ?>
				<?php echo CHtml::activeTextField($model, 'quantity_minimum'); ?>
				<?php echo CHtml::error($model, 'quantity_minimum'); ?>
			</div>


			<div class="row">
				<?php $productUnitProduct = $model->product(array('scopes' => 'resetScope', 'with' => 'brand:resetScope')); ?>
				<?php echo CHtml::activeLabelEx($model, 'product_id'); ?>
				<?php echo CHtml::activeTextField($model, 'product_id', array('readonly' => true, 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
				<?php echo CHtml::openTag('span', array('id' => 'product_name')); ?>
				<?php echo CHtml::encode(CHtml::value($productUnitProduct, 'name')); ?>
				<?php echo CHtml::closeTag('span'); ?>
				<?php echo CHtml::error($model, 'product_id'); ?>

				<?php
				$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id' => 'product-dialog',
					// additional javascript options for the dialog plugin
					'options' => array(
						'title' => 'Product',
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
					'selectionChanged' => 'js:function(id) {
							$("#' . CHtml::activeId($model, 'product_id') . '").val($.fn.yiiGridView.getSelection(id));
							$("#product-dialog").dialog("close");
							if ($.fn.yiiGridView.getSelection(id) == "")
							{
								$("#product_code").html("");
								$("#product_name").html("");
								$("#product_type").html("");
								$("#product_size").html("");
							}
							else
							{
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxJsonProduct', array('id' => $model->id)) . '",
									data: $("form").serialize(),
									success: function(data) {
										$("#product_code").html(data.product_code);
										$("#product_name").html(data.product_name);
										$("#product_type").html(data.product_type);
										$("#product_size").html(data.product_size);
									},
								});
							}
						}',
					'columns' => array(
						'code',
						'name',
						'type',
						'size',
					),
				));
				?>
				<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
			</div>
		
			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'product_group_id'); ?>
				<?php echo CHtml::activeDropDownList($model, 'product_group_id', CHtml::listData(ProductGroup::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Grup')); ?>
				<?php echo CHtml::error($model, 'product_group_id'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'product_category_id'); ?>
				<?php echo CHtml::activeDropDownList($model, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Kategori')); ?>
				<?php echo CHtml::error($model, 'product_category_id'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'unit_id'); ?>
				<?php echo CHtml::activeDropDownList($model, 'unit_id', CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Satuan')); ?>
				<?php echo CHtml::error($model, 'unit_id'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model, 'is_inactive'); ?>
				<?php echo CHtml::activeDropDownList($model, 'is_inactive', array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL)); ?>
				<?php echo CHtml::error($model, 'is_inactive'); ?>
			</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
	</div>
	<?php echo CHtml::endForm(); ?>
</div>
