<?php if ($error === true && count($quotation->details) === 0): ?>
	<p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
<?php endif; ?>

<table style="border: 1px solid">
	<tr style="background-color:  #cd0a0a; color: white">
		<th style="text-align: center">Nama Barang</th>
		<th style="text-align: center">Quantity</th>
		<th style="text-align: center">Satuan</th>
		<th style="text-align: center">Harga Satuan</th>
		<th style="text-align: center">+/-(%) 1</th>
		<th style="text-align: center">+/-(%) 2</th>
		<th style="text-align: center">+/-(%) 3</th>
		<th style="text-align: center">+/-(%) 4</th>
		<th style="text-align: center">+/-(%) 5</th>
		<th style="text-align: center">Quote(%)</th>
		<th style="text-align: center">Total</th>
		<th style="text-align: center"></th>
	</tr>
	<?php foreach ($quotation->details as $i=>$detail): ?>
		<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
		<tr style="background-color: #FFF8DC">
			<td>
				<?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
				<?php echo CHtml::activeTextField($detail, "[$i]product_name"); ?>
			</td>
			<td style="text-align: center; width: 10%">
				<?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size'=>5, 'maxLength'=>20,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#'.CHtml::activeId($detail, "[$i]quantity").'").val(data.quantity);
							$("#'.CHtml::activeId($detail, "[$i]unit_id").'").val(data.unit_id);
							$("#unit_name_'.$i.'").html(data.unit_name);
							$("#unit_price_'.$i.'").html(data.unit_price);
							$("#'.CHtml::activeId($detail, "[$i]discount_1").'").val(data.discount_1);
							$("#'.CHtml::activeId($detail, "[$i]discount_2").'").val(data.discount_2);
							$("#'.CHtml::activeId($detail, "[$i]discount_3").'").val(data.discount_3);
							$("#'.CHtml::activeId($detail, "[$i]discount_4").'").val(data.discount_4);
							$("#'.CHtml::activeId($detail, "[$i]discount_5").'").val(data.discount_5);
							$("#total_'.$i.'").html(data.total);
							$("#sub_total").html(data.subTotal);	
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				Bulk: <?php echo CHtml::encode(CHtml::value($detail, 'product.quantity_bulk')); ?>
				<?php echo CHtml::error($detail, 'quantity'); ?>
			</td>
			<td style="text-align: right">
				<?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
				<?php echo CHtml::openTag('span', array('id' => "unit_name_$i")); ?>
				<?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
				<?php echo CHtml::closeTag('span'); ?>
			</td>
			<td style="text-align: right">
				<?php echo CHtml::activeTextField($detail, "[$i]unit_price", array('size'=>9, 'maxLength'=>10,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#unit_price_'.$i.'").html(data.unit_price);
							$("#total_'.$i.'").html(data.total);
							$("#sub_total").html(data.subTotal);	
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'unit_price'); ?>
			</td>
			 <td style="text-align: center">
				<?php echo CHtml::activeTextField($detail, "[$i]discount_1", array('size'=>3, 'maxLength'=>10,
					'onchange'=>CHtml::ajax(array(
					'type'=>'POST',
					'dataType'=>'JSON',
					'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
					'success'=>'function(data) {
						$("#unit_price_'.$i.'").html(data.unit_price);
						$("#total_'.$i.'").html(data.total);
						$("#sub_total").html(data.subTotal);
						$("#grand_total").html(data.grandTotal);
					}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'discount_1'); ?>
			</td>
			<td style="text-align: center">
				<?php echo CHtml::activeTextField($detail, "[$i]discount_2", array('size'=>3, 'maxLength'=>10,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#unit_price_'.$i.'").html(data.unit_price);
							$("#total_'.$i.'").html(data.total);
							$("#sub_total").html(data.subTotal);
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'discount_2'); ?>
			</td>
			<td style="text-align: center">
				<?php echo CHtml::activeTextField($detail, "[$i]discount_3", array('size'=>3, 'maxLength'=>10,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#unit_price_'.$i.'").html(data.unit_price);
							$("#total_'.$i.'").html(data.total);
							$("#sub_total").html(data.subTotal);
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'discount_3'); ?>
			</td>
			<td style="text-align: center">
				<?php echo CHtml::activeTextField($detail, "[$i]discount_4", array('size'=>3, 'maxLength'=>10,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#unit_price_'.$i.'").html(data.unit_price);
							$("#total_'.$i.'").html(data.total);
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'discount_4'); ?>
			</td>
			<td style="text-align: center">
				<?php echo CHtml::activeTextField($detail, "[$i]discount_5", array('size'=>3, 'maxLength'=>10,
					'onchange'=>CHtml::ajax(array(
						'type'=>'POST',
						'dataType'=>'JSON',
						'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
						'success'=>'function(data) {
							$("#unit_price_'.$i.'").html(data.unit_price);
							$("#total_'.$i.'").html(data.total);
							$("#grand_total").html(data.grandTotal);
						}',
					)),
				)); ?>
				<?php echo CHtml::error($detail, 'discount_5'); ?>
			</td>
			<td style="text-align: center">
				<?php echo CHtml::activeHiddenField($detail, "[$i]quotation_value"); ?>
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quotation_value'))); ?>
				<?php echo CHtml::error($detail, 'quotation_value'); ?>
			</td>
			<td style="text-align: right">
				<span id="total_<?php echo $i; ?>">
					<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
				</span>
			</td>
			<td style="width: 5%">
				<?php if ($detail->isNewRecord): ?>
					<?php echo CHtml::button('Delete', array(
						'onclick'=>CHtml::ajax(array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id'=>$quotation->header->id, 'index'=>$i)),
							'update'=>'#detail_div',
						)),
					)); ?>
				<?php else: ?>
				<?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'), array(
						'onchange'=>CHtml::ajax(array(
							'type'=>'POST',
							'dataType'=>'JSON',
							'url'=>CController::createUrl('ajaxJsonTotal', array('id'=>$quotation->header->id, 'index'=>$i)),
							'success'=>'function(data) {
								$("#unit_price_'.$i.'").html(data.unit_price);
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
		<td colspan="9" style="text-align: right; font-weight: bold">Total:</td>
		<td colspan="2"  style="text-align: right; font-weight: bold">
			<span id="grand_total">
				<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($quotation->grandTotal > 1000000) ? round($quotation->grandTotal, -3) : round($quotation->grandTotal, -2))); ?>
			</span>
		</td>
		<td></td>
	</tr>
</table>