<?php if ($error === true && count($purchasePayment->details) === 0): ?>
	<p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
<?php endif; ?>

<table style="border: 1px solid">
	<tr style="background-color: #cd0a0a; color: white">
		<th style="text-align: center; width: 20%">Jenis Pembayaran</th>
		<th style="text-align: center; width: 20%">Jumlah</th>
		<th style="text-align: center; width: 50%">Memo</th>
		<th style="text-align: center; width: 10%"></th>
	</tr>
	<?php foreach ($purchasePayment->details as $i=>$detail): ?>
		<tr style="background-color: #FFF8DC">
			<td style="text-align: center">
				<?php echo CHtml::activeDropDownList($detail, "[$i]payment_type_id", CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Jenis Pembayaran --')); ?>
				<?php echo CHtml::error($detail, 'payment_type_id'); ?>
			</td>
			<td style="text-align:right; width: 15%">
				<?php echo CHtml::activeTextField($detail, "[$i]amount", array(
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonSummary', array('id'=>$purchasePayment->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#amount_'.$i.'").html(data.amount);
							$("#total").html(data.total);
							$("#payment").html(data.payment);
							$("#remaining").html(data.remaining);
							$("#total_payment").html(data.total_payment);
						}',
					)),
				)); ?>
				<div id="amount_<?php echo $i; ?>" style="text-align: left; font-size: smaller">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
				</div>
				<?php echo CHtml::error($detail, 'amount'); ?>
			</td>
			<td style="text-align: right">
				<?php echo CHtml::activeTextField($detail, "[$i]memo", array('size'=>60, 'maxlength'=>60)); ?>
				<?php echo CHtml::error($detail, 'memo'); ?>
			</td>
			<td>
				<?php if ($detail->isNewRecord): ?>
					<?php echo CHtml::button('Delete', array(
						'onclick'=>CHtml::ajax(array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajaxHtmlRemovePayment', array('id'=>$purchasePayment->header->id, 'index'=>$i)),
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
		<td></td>
		<td style="font-weight: bold">Grand Total:</td>
		<td style="text-align: right; font-weight: bold">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment->header, 'purchaseReceiptHeader.grand_total'))); ?>
            </span>
		</td>
		<td></td>
	</tr>
	<?php if ($purchasePayment->header->isNewRecord): ?>
		<tr style="background-color: #F5DEB3">
			<td></td>
			<td style="font-weight: bold">Pembayaran Lunas:</td>
			<td style="text-align: right;font-weight: bold">
				<span id="payment">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment, 'totalPayment'))); ?>
				</span>
			</td>
			<td></td>
		</tr>
		<tr style="background-color: #F5DEB3">
			<td></td>
			<td style="font-weight: bold">Sisa Pembayaran:</td>
			<td style="text-align: right;font-weight: bold">
				<span id="remaining">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil(CHtml::value($purchasePayment, 'remaining')))); ?>
				</span>
			</td>
			<td></td>
		</tr>
	<?php endif; ?>
	<?php /*if (!$purchasePayment->header->isNewRecord): ?>
		<tr style="background-color: #F5DEB3">
			<td></td>
			<td style="font-weight: bold">Total Pembayaran:</td>
			<td style="text-align: right;font-weight: bold">
				<span id="total_payment">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchasePayment, 'totalPayment'))); ?>
				</span>
			</td>
			<td></td>
		</tr>
	<?php endif; */?>
</table>
