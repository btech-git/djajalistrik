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
		<div style="font-size: larger">NOTA PENERIMAAN KAS/BANK</div>
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
						<div class="divtablecell info hcolumn1header" style="font-weight: bold">FAKTUR NO.&nbsp : <?php echo CHtml::encode(CHtml::value($deposit, 'number')); ?></div>
					</div>
				</div>
			</div>
			<div class="divtablecell hcolumn2">
				<div class="divtable">
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($deposit, 'date')))); ?></div>
					</div>
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2header" style="font-weight: bold">ACCOUNT :</div>
						<div class="divtablecell info hcolumn2value"><?php echo CHtml::encode($account->name); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br />

	<table class="memo">
		 <tr id="theader">
			<th>Description</th>
			<th>Jumlah</th>
			<th>Memo</th>
		</tr>
		<?php foreach ($depositDetails as $i=>$detail): ?>
		<tr class="titems">
			<td><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
			<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?></td>
			<td style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td style="border-top: 2px solid; font-weight: bold; text-align: right">Total</td>
			<td style="border-top: 2px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', round(CHtml::value($deposit, 'total'), -2))); ?></td>
			<td style="border-top: 2px solid"></td>
		</tr>
	</table>

	<div style="text-transform: capitalize">
		TERBILANG:
		<?php echo CHtml::encode(NumberWord::numberName(round(CHtml::value($deposit, 'total'), -2))); ?>
		rupiah
	</div>

	<br />

	<div>
		CATATAN: <?php echo CHtml::encode(CHtml::value($deposit, 'note')); ?>
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
				<div><?php echo CHtml::encode(CHtml::value($deposit, 'admin.name')); ?></div>
			</div>
		</div>
	</div>
</div>