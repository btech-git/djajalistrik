<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'invoice-temporary-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'Nomor Bon'); ?>
		<?php echo $form->textField($model, 'number', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Tanggal Bon'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
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
		<?php echo $form->error($model, 'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'customer_id'); ?>
		<?php echo CHtml::activeDropDownList($model, 'customer_id', CHtml::listData(Customer::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Customer --')); ?>
		<?php echo $form->error($model, 'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Total Bon'); ?>
		<?php echo $form->textField($model, 'amount', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model, 'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Tanggal T T'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'date_receipt',
			// additional javascript options for the date picker plugin
			'options' => array(
				'dateFormat' => 'yy-mm-dd',
			),
			'htmlOptions' => array(
				'readonly' => true,
			),
		));
		?>
		<?php echo $form->error($model, 'date_receipt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Keterangan'); ?>
		<?php echo $form->textArea($model, 'note', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'return'); ?>
		<?php echo $form->textArea($model, 'return', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'return'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Jumlah Pembayaran'); ?>
		<?php echo $form->textField($model, 'amount_paid', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model, 'amount_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Tanggal Pembayaran'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'date_payment',
			// additional javascript options for the date picker plugin
			'options' => array(
				'dateFormat' => 'yy-mm-dd',
			),
			'htmlOptions' => array(
				'readonly' => true,
			),
		));
		?>
		<?php echo $form->error($model, 'date_payment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Metode Pembayaran'); ?>
		<?php echo CHtml::activeDropDownList($model, 'payment_type_id', CHtml::listData(PaymentType::model()->active()->findAll(), 'id', 'name'), array('empty' => '- Pilih Tipe Pembayaran -')); ?>
		<?php echo $form->error($model, 'payment_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Status Pembayaran'); ?>
		<?php echo $form->dropDownList($model, 'is_paid', array(InvoiceTemporary::UNPAID=>InvoiceTemporary::UNPAID_LITERAL, InvoiceTemporary::PAID=>InvoiceTemporary::PAID_LITERAL)); ?>
		<?php echo $form->error($model, 'is_paid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->