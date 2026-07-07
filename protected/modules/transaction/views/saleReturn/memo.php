<?php
	Yii::app()->clientScript->registerScript('memo', '
		$("#header").addClass("hide");
		$("#mainmenu").addClass("hide");
		$(".breadcrumbs").addClass("hide");
		$("#footer").addClass("hide");
	');
	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
	Yii::app()->clientScript->registerCss('memo', '
		.hcolumn1 { width: 50% }
		.hcolumn2 { width: 50% }

		.hcolumn1header { width: 35% }
		.hcolumn1value { width: 65% }
		.hcolumn2header { width: 35% }
		.hcolumn2value { width: 65% }

		.sig1 { width: 25% }
		.sig2 { width: 50% }
		.sig3 { width: 25% }
	');
?>
<div id="detail_div">
	<div id="memoheader">
		<div style="font-size: larger">NOTA RETUR PENJUALAN BARANG</div>
	</div>

	<br />

	<div class="memonote">
		<div class="divtable">
			<div class="divtablecell hcolumn1">
				<div class="divtable">
					<div class="divtablerow">
						<div class="divtablecell info hcolumn1value" style="font-size:150%;font-weight: bold"><?php echo CHtml::encode($branch->name); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($branch->address); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn1value">Telp. <?php echo CHtml::encode($branch->phone); ?> Fax. <?php echo CHtml::encode($branch->fax); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn1header" style="font-weight: bold">FAKTUR NO.&nbsp : <?php echo CHtml::encode(CHtml::value($saleReturn, 'number')); ?></div>
					</div>
				</div>
			</div>
			<div class="divtablecell hcolumn2">
				<div class="divtable">
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($saleReturn, 'date')))); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2header">Kepada Yth.</div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($orderHeader->customer->name); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($orderHeader->customer->address_1); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($orderHeader->customer->city); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br />

	<table class="memo">
		<tr id="theader">
			<th>Nama Barang</th>
			<th>Jumlah Retur</th>
			<th>Satuan</th>
			<th>Harga Satuan</th>
			<th>Total</th>
		</tr>
		<?php foreach ($saleReturnDetails as $detail): ?>
			<?php //$detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
			<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
		
			<tr class="titems">
				<td><?php echo CHtml::encode(CHtml::value($detail, 'deliveryDetail.orderDetail.product_name')); ?></td>
				<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
				<td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
				<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
				<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan ="4" style="border-top: 2px solid; font-weight: bold; text-align: right">Total</td>
			<td style="border-top: 2px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleReturn->grandTotal, -2)); ?></td>
		</tr>
	</table>

	<br />

	<div>
		CATATAN: <?php echo CHtml::encode(CHtml::value($saleReturn, 'note')); ?>
	</div>

	<br />

	<div class="memosig">
		<div class="divtable">
			<div class="divtablecell sig1">
				<div>DISETUJUI OLEH,</div>
			</div>
			<div class="divtablecell sig2">
				&nbsp;
			</div>
			<div class="divtablecell sig3">
				<div>DIBUAT OLEH,</div>
				<br/><br/><br/>
				<div><?php echo CHtml::encode(CHtml::value($saleReturn, 'admin.name')); ?></div>
			</div>
		</div>
	</div>
</div>