<?php if ($error === true && count($receiptTemporary->details) === 0): ?>
	<p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
<?php endif; ?>

<table style="border: 1px solid">
	<tr style="background-color: #cd0a0a; color: white">
		<th style="text-align: center; width: 15%">Invoice #</th>
		<th style="text-align: center; width: 15%">Tanggal</th>
		<th style="text-align: center; width: 15%">Jumlah Dibayar</th>
		<th style="text-align: center; width: 15%">Tanggal Bayar</th>
		<th style="text-align: center; width: 15%">Jenis Pembayaran</th>
		<th style="text-align: center; width: 15%">Jumlah</th>
		<th style="text-align: center; width: 10%"></th>
	</tr>
	<?php foreach ($receiptTemporary->details as $i=>$detail): ?>
	
	<?php $detailInvoiceTemporary= $detail->invoiceTemporary(array('scopes' => 'resetScope', 'with' => 'customer:resetScope')); ?>
	
		<tr style="background-color: #FFF8DC">
			<td style="width: auto">
				<?php echo CHtml::activeHiddenField($detail, "[$i]invoice_temporary_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detailInvoiceTemporary, 'number')); ?>
			</td>
			<td style="text-align:right; width: 15%">
				<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($detailInvoiceTemporary, 'date')))); ?>
			</td>
			<td style="text-align: right">
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailInvoiceTemporary, 'amount_paid'))); ?>
			</td>
			<td style="text-align:right; width: 15%">
				<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($detailInvoiceTemporary, 'date_payment')))); ?>
			</td>
			<td style="text-align:right; width: 15%">
				<?php echo CHtml::encode(CHtml::value($detailInvoiceTemporary, 'paymentType.name')); ?>
			</td>
			<td style="text-align: right">
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailInvoiceTemporary, 'amount'))); ?>
			</td>
			<td>
				<?php if ($detail->isNewRecord): ?>
					<?php echo CHtml::button('Delete', array(
						'onclick'=>CHtml::ajax(array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $receiptTemporary->header->id, 'index'=>$i)),
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
                <td colspan="5" style="text-align: right; font-weight: bold">Grand Total:</td>
                <td style="text-align: right; font-weight: bold">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receiptTemporary->totalInvoice)); ?>
				</td>
				<td></td>
        </tr>
</table>