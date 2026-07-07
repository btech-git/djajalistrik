<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'product-discount-category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo CHtml::label('Kategori Produk', false); ?>
		<?php echo CHtml::dropDownList('ProductCategoryId', '', CHtml::listData(ProductCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name')); ?>		
		<?php //echo $form->error($model, 'product_category_id'); ?>
	</div>

	<table>
		<tr>
			<td>Disc Kategori</td>
			<td>Disc 1</td>
			<td>Disc 2</td>
			<td>Disc 3</td>
			<td>Disc 4</td>
			<td>Disc 5</td>
		</tr>
		<?php foreach ($productDiscountCategories as $i => $productDiscountCategory): ?>
		<tr>
			<td>
				<?php echo $form->hiddenField($productDiscountCategory, "[$i]discount_category_id", array('size'=>5, 'maxlength'=>18)); ?>
				<?php echo CHtml::encode(CHtml::value($productDiscountCategory, 'discountCategory.name')); ?>
			</td>
			<td>
				<?php echo $form->textField($productDiscountCategory, "[$i]value_1", array('size'=>5, 'maxlength'=>18)); ?>
				<?php echo $form->error($productDiscountCategory, 'value_1'); ?>
			</td>
			<td>
				<?php echo $form->textField($productDiscountCategory, "[$i]value_2", array('size'=>5, 'maxlength'=>18)); ?>
				<?php echo $form->error($productDiscountCategory, 'value_2'); ?>
			</td>
			<td>
				<?php echo $form->textField($productDiscountCategory, "[$i]value_3", array('size'=>5, 'maxlength'=>18)); ?>
				<?php echo $form->error($productDiscountCategory, 'value_3'); ?>
			</td>
			<td>
				<?php echo $form->textField($productDiscountCategory, "[$i]value_4", array('size'=>5, 'maxlength'=>18)); ?>
				<?php echo $form->error($productDiscountCategory, 'value_4'); ?>
			</td>
			<td>
				<?php echo $form->textField($productDiscountCategory, "[$i]value_5", array('size'=>5, 'maxlength'=>18)); ?>
				<?php echo $form->error($productDiscountCategory, 'value_5'); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Create'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->