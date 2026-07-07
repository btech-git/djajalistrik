<?php if ($error === true && count($transfer->details) === 0): ?>
	<p style="color: red">Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.</p>
<?php endif; ?>

<table style="border: 1px solid">
	<tr style="background-color: #cd0a0a; color: white">
		<th style="text-align: center">Nama Barang</th>
		<th style="text-align: center">Stok</th>
		<th style="text-align: center">Jumlah</th>
		<th style="text-align: center">Satuan</th>
		<th style="text-align: center"></th>
	</tr>
	<?php foreach ($transfer->details as $i=>$detail): ?>
	
		<?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
		<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
	
		<tr style="background-color: #FFF8DC">
			<td>
				<?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?>
			</td>
			<td style="text-align: center; width: 10%">
				<?php echo CHtml::hiddenField("current_stock_{$i}", ($currentStock = $detail->product->getStock($transfer->header->warehouse_id_from))); ?>
				<span><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $currentStock)); ?></span>
			</td>
			<td style="text-align: center; width: 15%">
				<?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size'=>7, 'maxLength'=>20,
					'onchange' => 'if (parseInt($(this).val()) > parseInt($("#current_stock_'.$i.'").val())) $(this).val($("#current_stock_'.$i.'").val());'
				)); ?>
				<?php echo CHtml::error($detail, 'quantity'); ?>
			</td>
			<td style="text-align: center; width: 10%">
				<?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
				<?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?>
			</td>
			<td style="width: 5%">
				<?php echo CHtml::button('Delete', array(
					'onclick'=>CHtml::ajax(array(
						'type'=>'POST',
						'url'=>CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $transfer->header->id, 'index'=>$i)),
						'update'=>'#detail_div',
					)),
				)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
