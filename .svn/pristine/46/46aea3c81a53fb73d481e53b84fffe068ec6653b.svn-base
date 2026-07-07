<?php
	Yii::app()->clientScript->registerScript('memo', '
		$("#header").addClass("hide");
		$("#mainmenu").addClass("hide");
		$(".breadcrumbs").addClass("hide");
		$("#footer").addClass("hide");
	');
	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/transaction/memo.css');
	Yii::app()->clientScript->registerCss('memo', '
		.hcolumn1 { width: 50% }
		.hcolumn2 { width: 50% }

		.hcolumn1header { width: 35% }
		.hcolumn1value { width: 65% }
		.hcolumn2header { width: 35% }
		.hcolumn2value { width: 65% }

		.sig1 { width: 15% }
		.sig2 { width: 15% }
		.sig3 { width: 15% }
		.sig4 { width: 15% }
		.sig5 { width: 15% }
		.sig6 { width: 25% }
	');
?>
<div id="detail_div">
	<div id="memoheader">
		<div style="font-size: larger">QUOTATION</div>
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
						<div class="divtablecell info hcolumn1header" style="font-weight: bold">FAKTUR NO.&nbsp : <?php echo CHtml::encode(CHtml::value($quotation, 'number')); ?></div>
					</div>
				</div>
			</div>
			<div class="divtablecell hcolumn2">
				<div class="divtable">
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($quotation, 'date')))); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2header">Kepada Yth.</div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->name); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->address_1); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($customer->city); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br />

	<table class="memo">
		<tr id="theader">
		   <th>Nama Produk</th>
		   <th>Jumlah</th>
		   <th>Satuan</th>
		   <th>Harga Satuan</th>
		   <th>Disc 1(%)</th>
		   <th>Disc 2(%)</th>
		   <th>Disc 3(%)</th>
		   <th>Disc 4(%)</th>
		   <th>Disc 5(%)</th>
		   <th>Quote Disc</th>
		   <th>Total</th>
		</tr>
			<?php foreach ($quotationDetails as $i=>$detail): ?>
				<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
				<tr class="titems">
					<td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
					<td style="width: 5%"><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
					<td style="text-align: right; width: 12%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_1'))); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_2'))); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_3'))); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_4'))); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount_5'))); ?></td>
					<td style="text-align: right; width: 5%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotation_value'))); ?></td>
					<td style="text-align: right; width: 15%"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="10" style="border-top: 2px solid; font-weight: bold; text-align: right">Grand Total</td>
				<td style="border-top: 2px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($quotation->grandTotal > 1000000) ? round($quotation->grandTotal, -3) : round($quotation->grandTotal, -2))); ?></td>
			</tr>
	</table>

	<div style="text-transform: capitalize">
		TERBILANG:
		<?php echo CHtml::encode(NumberWord::numberName(round(CHtml::value($quotation, 'grandTotal'), -2))); ?>
		rupiah
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
				<div><?php echo CHtml::encode(CHtml::value($quotation, 'admin.name')); ?></div>
			</div>
		</div>
	</div>
</div>