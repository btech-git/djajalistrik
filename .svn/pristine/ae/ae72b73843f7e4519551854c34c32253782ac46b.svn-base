<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'code'); ?>
		<?php echo $form->textField($model, 'code', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'brand_id'); ?>
		<?php echo $form->dropDownList($model,'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model, 'brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_group_id'); ?>
		<?php echo $form->dropDownList($model,'product_group_id', CHtml::listData(ProductGroup::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Product Group')); ?>
		<?php echo $form->error($model, 'product_group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'unit_id'); ?>
		<?php echo $form->dropDownList($model,'unit_id', CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Satuan')); ?>
		<?php echo $form->error($model, 'unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_category_id'); ?>
		<?php echo $form->dropDownList($model,'product_category_id', CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Product Category')); ?>
		<?php echo $form->error($model, 'product_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Selling Price'); ?>
		<?php echo $form->textField($model, 'price'); ?>
		<?php echo $form->error($model, 'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'type'); ?>
		<?php echo $form->textField($model, 'type', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'size'); ?>
		<?php echo $form->textField($model, 'size', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'color'); ?>
		<?php echo $form->textField($model, 'color', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'color'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'volume'); ?>
		<?php echo $form->textField($model, 'volume', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model, 'volume'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'quantity_minimum'); ?>
		<?php echo $form->textField($model, 'quantity_minimum', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model, 'quantity_minimum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'is_inactive'); ?>
		<?php echo $form->dropDownList($model,'is_inactive', array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL)); ?>
		<?php echo $form->error($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->