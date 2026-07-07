<table style="border: 1px solid">
	<tr style="background-color: #cd0a0a; color: white">
		<th style="text-align: center">Nama Barang</th>
		<?php if (!empty($purchaseReturn->header->receive_header_id) && $purchaseReturn->header->isNewRecord): ?>
			<th style="text-align: center">Jml Terima</th>
		<?php endif; ?>
		<th style="text-align: center">Jml Retur</th>
		<th style="text-align: center">Satuan</th>
		<th style="text-align: center">Harga Satuan</th>
		<th style="text-align: center">Total</th>
		<th style="text-align: center"></th>
	</tr>
	
	<?php foreach ($purchaseReturn->details as $i=>$detail): ?>
		
		<?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
		<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
	
		<tr style="background-color: #FFF8DC">
			<td>
				<?php echo CHtml::activeHiddenField($detail, "[$i]receive_detail_id"); ?>
				<?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?>
			</td>
			<?php if (!empty($purchaseReturn->header->receive_header_id) && $purchaseReturn->header->isNewRecord): ?>
				<td style="text-align:right; width: 10%">
					<?php echo CHtml::hiddenField("quantity_received_{$i}", ($quantityReceived = $detail->receiveDetail->quantity_receive)); ?>
					<span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityReceived)); ?></span>
				</td>
			<?php endif; ?>
			<td style="text-align:center; width: 10%">
				<?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size'=>7, 'maxLength'=>20,
					'onchange'=>'if (parseInt($(this).val()) > parseInt($("#quantity_received_'.$i.'").val())) $(this).val($("#quantity_received_'.$i.'").val());'. 
					CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotalDetail', array('id'=>$purchaseReturn->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#total_'.$i.'").html(data.total);
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'quantity'); ?>
			</td>
			<td style="text-align: center; width: 10%">
				<?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
			</td>
			<td style="text-align: right; width: 15%">
				<?php echo CHtml::hiddenField("unit_price_{$i}", ($unitPrice = $detail->receiveDetail->purchaseDetail->unit_price)); ?>
                <span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $unitPrice)); ?></span>
			</td>
			<td style="text-align: right; width: 15%">
				<span id="total_<?php echo $i; ?>">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getTotal($purchaseReturn->header->receive_header_id))); ?>
                </span>
			</td>
			<td style="width: 5%">
				<?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $purchaseReturn->header->id, 'index'=>$i)),
                            'update'=>'#detail_div',
                        )),
                    )); ?>
				<?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'), array(
						'onchange'=>CHtml::ajax(array(
							'type'=>'POST',
							'dataType'=>'JSON',
							'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$purchaseReturn->header->id, 'index'=>$i)),
							'success'=>'function(data) {
								$("#total_'.$i.'").html(data.total);
								$("#grand_total").html(data.grandTotal);
							}',
						)),
					)); ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
