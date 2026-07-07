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
	<?php foreach ($saleReturn->newProducts as $i=>$detail): ?>
	
		<?php $detailUnit = $detail->deliveryNewProduct->orderNewProduct->unit(array('scopes' => 'resetScope')); ?>
		<tr style="background-color: #FFF8DC">
			<td>
				<?php echo CHtml::activeHiddenField($detail, "[$i]delivery_new_product_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detail, 'deliveryNewProduct.orderNewProduct.name')); ?>
			</td>
            
			<?php if (!empty($saleReturn->header->delivery_header_id) && $saleReturn->header->isNewRecord): ?>
				<td style="text-align:center; width: 10%">
					<?php echo CHtml::hiddenField("quantity_order_{$i}", ($quantityOrdered = $detail->deliveryNewProduct->getQuantityReturnRemaining())); ?>
					<span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityOrdered)); ?></span>
				</td>
			<?php endif; ?>
                
			<td style="text-align:center; width: 10%">
				<?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size'=>7, 'maxLength'=>20,
					'onchange'=>'if (parseInt($(this).val()) > parseInt($("#quantity_order_'.$i.'").val())) $(this).val($("#quantity_order_'.$i.'").val());'. 
					CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotalNewProduct', array('id'=>$saleReturn->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#total_new_product_'.$i.'").html(data.totalNewProduct);
							$("#grand_total_new_product").html(data.grandTotalNewProduct);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'quantity'); ?>
			</td>
            
			<td style="text-align: center; width: 10%">
				<?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
			</td>
            
			<td style="text-align:right; width: 15%">
				<?php echo CHtml::activeHiddenField($detail, "[$i]unit_price");  ?>
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->unit_price)); ?>
			</td>
            
			<td style="text-align: right; width: 15%">
				<span id="total_new_product_<?php echo $i; ?>">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getTotal($saleReturn->header->delivery_header_id))); ?>
				</span>
			</td>
            
			<td style="width: 5%">
				<?php if ($detail->isNewRecord): ?>
					<?php echo CHtml::button('Delete', array(
						'onclick'=>CHtml::ajax(array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajaxHtmlRemoveNewProduct', array('id'=>$saleReturn->header->id, 'index'=>$i)),
							'update'=>'#new_product_div',
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
			<span id="grand_total_new_product">
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->getGrandTotalNewProduct())); ?>
			</span>
		</td>
		<td></td>
	</tr>
</table>
