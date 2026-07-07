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
		.sig2 { width: 25% }
		.sig3 { width: 25% }
	');
?>
<div id="detail_div">
	<div id="memoheader">
		<div style="font-size: larger">NOTA RETUR PEMBELIAN BARANG</div>
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
						<div class="divtablecell info hcolumn1header" style="font-weight: bold">FAKTUR NO.&nbsp : <?php echo CHtml::encode(CHtml::value($purchaseReturn, 'number')); ?></div>
					</div>
				</div>
			</div>
			<div class="divtablecell hcolumn2">
				<div class="divtable">
					<div class="divtablerow">
						<div class="divtablecell info hcolumn2value">Jakarta,&nbsp<?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchaseReturn, 'date')))); ?></div>
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

	<table class="memo" style="width: 80%">
		<tr id="theader">
			<th>Nama Barang</th>
			<th style="width: 10%">Jumlah Retur</th>
			<th style="width: 10%">Satuan</th>
			<th style="width: 15%">Harga Satuan</th>
			<th style="width: 15%">Total</th>
		</tr>
        
        <?php if (count($purchaseReturnDetails > 0)): ?>
            <?php foreach ($purchaseReturnDetails as $detail): ?>
                <?php $detailProduct = $detail->product(array('scopes' => 'resetScope')); ?>
                <?php $detailUnit = $detail->unit(array('scopes' => 'resetScope')); ?>
                <tr class="titems">
                    <td><?php echo CHtml::encode(CHtml::value($detailProduct, 'name')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailUnit, 'name')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->receiveDetail->purchaseDetail->unit_price)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getTotal($purchaseReturn->receive_header_id))); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
               
        <?php if (count($purchaseReturn->purchaseReturnNewProducts > 0)): ?>
            <?php foreach ($purchaseReturn->purchaseReturnNewProducts as $newProduct): ?>
                <tr class="titems">
                    <td><?php echo CHtml::encode(CHtml::value($newProduct, 'receiveNewProduct.purchaseNewProduct.product_name')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($newProduct, 'quantity'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($newProduct, 'receiveNewProduct.purchaseNewProduct.unit.name')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $newProduct->receiveNewProduct->purchaseNewProduct->unit_price)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $newProduct->getTotal($purchaseReturn->receive_header_id))); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
                 
        <tr>
            <td colspan="4" style="border-top: 2px solid; font-weight: bold; text-align: right">Total</td>
            <td style="border-top: 2px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($grandTotal = $purchaseReturn->getGrandTotal($purchaseReturn->receive_header_id)) > 1000000 ? round($grandTotal, -3) : round($grandTotal, -2))); ?></td>
        </tr>
	</table>

	<br />

	<div>
		CATATAN: <?php echo CHtml::encode(CHtml::value($purchaseReturn, 'note')); ?>
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
				<div><?php echo CHtml::encode(CHtml::value($purchaseReturn, 'admin.name')); ?></div>
			</div>
		</div>
	</div>
</div>