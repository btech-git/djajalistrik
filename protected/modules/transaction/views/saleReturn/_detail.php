<table style="border: 1px solid">
	<tr style="background-color: #cd0a0a; color: white">
		<th style="text-align: center">Nama Barang</th>
		<?php if (!empty($saleReturn->header->delivery_header_id) && $saleReturn->header->isNewRecord): ?>
			<th style="text-align: center">Jumlah Kirim</th>
		<?php endif; ?>
		<th style="text-align: center">Jumlah Retur</th>
		<th style="text-align: center">Satuan</th>
		<th style="text-align: center">Harga Satuan</th>
		<th style="text-align: center">Total</th>
		<th style="text-align: center"></th>
	</tr>
	<?php foreach ($saleReturn->details as $i=>$detail): ?>
	
		<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
		<tr style="background-color: #FFF8DC">
			<td>
				<?php echo CHtml::activeHiddenField($detail, "[$i]delivery_detail_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detail, 'deliveryDetail.orderDetail.product_name')); ?>
			</td>
            
			<?php if (!empty($saleReturn->header->delivery_header_id) && $saleReturn->header->isNewRecord): ?>
				<td style="text-align:center; width: 10%">
					<?php echo CHtml::hiddenField("quantity_ordered_{$i}", ($quantityOrdered = $detail->deliveryDetail->getQuantityReturnRemaining())); ?>
					<span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityOrdered)); ?></span>
				</td>
			<?php endif; ?>
                
			<td style="text-align:center; width: 10%">
				<?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size'=>7, 'maxLength'=>20,
					'onchange'=>'if (parseInt($(this).val()) > parseInt($("#quantity_ordered_'.$i.'").val())) $(this).val($("#quantity_ordered_'.$i.'").val());'. 
					CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$saleReturn->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#unit_price_'.$i.'").html(data.unitPrice);
							$("#total_'.$i.'").html(data.total);
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'quantity'); ?>
			</td>
            
			<td style="text-align: center; width: 10%">
				<?php echo CHtml::activeHiddenField($detail, "[$i]unit_id");  ?>
				<?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
			</td>
            
			<td style="text-align:right; width: 15%">
				<?php echo CHtml::activeHiddenField($detail, "[$i]unit_price");  ?>
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->unit_price)); ?>
			</td>
            
			<td style="text-align: right; width: 15%">
				<span id="total_<?php echo $i; ?>">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getTotal($saleReturn->header->delivery_header_id))); ?>
				</span>
			</td>
            
			<td style="width: 5%">
				<?php if ($detail->isNewRecord): ?>
					<?php echo CHtml::button('Delete', array(
						'onclick'=>CHtml::ajax(array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id'=>$saleReturn->header->id, 'index'=>$i)),
							'update'=>'#detail_div',
						)),
					)); ?>
				<?php else: ?>
					<?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'), array(
						'onchange'=>CHtml::ajax(array(
							'type'=>'POST',
							'dataType'=>'JSON',
							'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$saleReturn->header->id, 'index'=>$i)),
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
        
	<tr style="background-color: #F5DEB3">
		<?php if (!empty($saleReturn->header->delivery_header_id) && $saleReturn->header->isNewRecord): ?>
			<td></td>
		<?php endif; ?>
		<td colspan="4" style="text-align: right; font-weight: bold">Grand Total:</td>
		<td style="text-align: right; font-weight: bold">
			<span id="grand_total">
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->getGrandTotal())); ?>
			</span>
		</td>
		<td></td>
	</tr>
</table>
