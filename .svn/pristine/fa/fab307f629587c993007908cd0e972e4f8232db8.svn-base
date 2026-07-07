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
		<div style="font-size: larger">PENERIMAAN BARANG</div>
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
						<div class="divtablecell info hcolumn1header" style="font-weight: bold">FAKTUR NO.&nbsp : <?php echo CHtml::encode(CHtml::value($receive, 'number')); ?></div>
					</div>
				</div>
			</div>
			<div class="divtablecell hcolumn2">
				<div class="divtable">
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($receive, 'date')))); ?></div>
					</div>	
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2header">Kepada Yth.</div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($purchaseHeader->supplier->company); ?> &nbsp (<?php echo CHtml::encode($purchaseHeader->supplier->name); ?>)</div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($purchaseHeader->supplier->address); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($purchaseHeader->supplier->city); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br />

	<table class="memo">
		<tr id="theader">
			<th>Nama Barang</th>
			<th>Jumlah</th>
			<th>Satuan</th>
		</tr>
		<?php foreach ($receiveDetails as $detail): ?>
			<?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
			<?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
			<tr class="titems">
				<td><?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?></td>
				<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_receive'))); ?></td>
				<td style="text-align: right"><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

	<table class="memo">
		<tr id="theader">
			<th>Nama Barang</th>
			<th>Jumlah</th>
		</tr>
		<?php foreach ($receiveNewProducts as $detail): ?>
			<tr class="titems">
				<td><?php echo CHtml::encode(CHtml::value($detail, 'purchaseNewProduct.product_name')); ?></td>
				<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />

	<div>
		CATATAN: <?php echo CHtml::encode(CHtml::value($receive, 'note')); ?>
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
				<div><?php echo CHtml::encode(CHtml::value($receive, 'admin.name')); ?></div>
			</div>
		</div>
	</div>
</div>