<?php
$this->breadcrumbs = array(
	'Product Discount Categories'=>array('admin'),
	$model->id=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Product Discount Category', 'url'=>array('create')),
	array('label'=>'View Product Discount Category', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Product Discount Category', 'url'=>array('admin')),
);
?>

<h1>Update Product Discount Category <?php echo $model->id; ?></h1>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'product-form',
		'enableAjaxValidation' => false,
		));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_category_id'); ?>
		<?php echo $form->dropDownList($model, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Kategori Produk')); ?>
		<?php echo $form->error($model, 'product_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'discount_category_id'); ?>
		<?php echo $form->dropDownList($model, 'discount_category_id', CHtml::listData(DiscountCategory::model()->findAll(), 'id', 'name'), array('empty' => 'Pilih Kategori Diskon')); ?>
		<?php echo $form->error($model, 'discount_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'value_1'); ?>
		<?php echo $form->textField($model, 'value_1'); ?>
		<?php echo $form->error($model, 'value_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'value_2'); ?>
		<?php echo $form->textField($model, 'value_2'); ?>
		<?php echo $form->error($model, 'value_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'value_3'); ?>
		<?php echo $form->textField($model, 'value_3'); ?>
		<?php echo $form->error($model, 'value_3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'value_4'); ?>
		<?php echo $form->textField($model, 'value_4'); ?>
		<?php echo $form->error($model, 'value_4'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'value_5'); ?>
		<?php echo $form->textField($model, 'value_5'); ?>
		<?php echo $form->error($model, 'value_5'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'is_inactive'); ?>
		<?php echo $form->dropDownList($model, 'is_inactive', array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL)); ?>
		<?php echo $form->error($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->