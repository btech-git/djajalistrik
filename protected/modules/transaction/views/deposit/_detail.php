<?php if ($error === true && count($deposit->details) === 0): ?>
	<p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
<?php endif; ?>

<table style="border: 1px solid">
  <tr style="background-color: #cd0a0a; color: white">
		<th style="text-align: center">Description</th>
		<th style="text-align: center">Jumlah</th>
		<th style="text-align: center">Memo</th>
		<th style="text-align: center"></th>
  </tr>
	<?php foreach ($deposit->details as $i=>$detail): ?>
		<tr style="background-color: #FFF8DC">
			<td style="text-align: center; width: 15%">
				<?php echo CHtml::activeTextField($detail, "[$i]description", array('size'=>30, 'maxlength'=>60)); ?>
				<?php echo CHtml::error($detail, 'description'); ?>
			</td>
			<td style="text-align: center; width: 15%">
				<?php echo CHtml::activeTextField($detail, "[$i]amount", array('size'=>10, 'maxlength'=>10,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$deposit->header->id, 'index'=>$i)),
						'success'=>'function(data) {
								$("#amount_'.$i.'").html(data.amount);
								$("#total").html(data.total);
						}',
					)),
				)); ?>
				<div id="amount_<?php echo $i; ?>" style="text-align: left; font-size: smaller">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
				</div>
				<?php echo CHtml::error($detail, 'amount'); ?>
			</td>
			<td style="text-align: center; width: 15%">
				<?php echo CHtml::activeTextField($detail, "[$i]memo", array('size'=>30, 'maxlength'=>60)); ?>
				<?php echo CHtml::error($detail, 'memo'); ?>
			</td>
			<td style="width: 5%">
				<?php if ($detail->isNewRecord): ?>
					<?php echo CHtml::button('Delete', array(
						'onclick'=>CHtml::ajax(array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id'=>$deposit->header->id, 'index'=>$i)),
							'update'=>'#detail_div',
						)),
					)); ?>
				<?php else: ?>
					<?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tr style="background-color: #F5DEB3">
			<td style="font-weight: bold; text-align: right">Total</td>
			<td style="font-weight: bold; text-align: center">
				<span id="total">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',ceil($deposit->total))); ?></td>
				</span>
			<td></td>
			<td></td>
        </tr>
</table>