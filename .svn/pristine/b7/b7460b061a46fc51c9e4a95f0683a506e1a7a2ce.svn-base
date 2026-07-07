<div class="form">

	<?php echo CHtml::beginForm(); ?>
		<div class="container">
			<div class="span-12">
				<div class="row">
					<?php echo CHtml::label('Pengeluaran #', false); ?>
					<?php echo CHtml::encode(CHtml::value($expense->header, 'number')); ?>
					<?php echo CHtml::error($expense->header, 'number'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::label('Tanggal', false); ?>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model' => $expense->header,
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
					<?php echo CHtml::error($expense->header, 'date'); ?>
				</div>
				
				<div class="row">
					<?php echo CHtml::activeLabelEx($expense->header, 'account_id'); ?>
						<?php echo CHtml::activeDropDownList($expense->header, 'account_id', CHtml::listData(Account::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Akun --'))?>
					<?php echo CHtml::error($expense->header, 'account_id'); ?>
				</div>
			</div>
			
			<div class="span-12 last">
				<div class="row">
					 <?php echo CHtml::label('Catatan', ''); ?>
					 <?php echo CHtml::activeTextArea($expense->header, 'note'); ?>
					 <?php echo CHtml::error($expense->header, 'note'); ?>
				</div>
			</div>
		</div>
	
		<hr />

		<div class="row buttons">
			<?php echo CHtml::button('Tambah Data Pengeluaran', array(
				'onclick'=>CHtml::ajax(array(
					'type'=>'POST',
					'url'=>CController::createUrl('ajaxHtmlAddPayment', array('id'=>$expense->header->id)),
					'update'=>'#detail_div',
				)),
			)); ?>
        </div>
		
		<div id="detail_div">
			<?php $this->renderPartial('_detail', array('expense'=>$expense, 'error'=>$error)); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
			<?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
		</div>

	<?php echo CHtml::endForm(); ?>

</div><!-- form -->