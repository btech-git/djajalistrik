<?php
Yii::app()->clientScript->registerScript('memo', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");
	window.print();
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 33% }
    .sig2 { width: 33% }
    .sig3 { width: 33% }
	
	.memoHeader {
		border-bottom: 5px double;
	}

	.memoHeaderCompany, .memoHeaderTitle {
		display: inline-block;
	}

	.memoHeaderCompany, .memoHeaderCompanyInfoTable tr td {
		font-weight: bold;
	}

	.memoHeaderCompanyImage {
		border: 1px solid;
		display: inline-block;
		height: 100px; 
		width: 100px;
	}

	.memoHeaderCompanyInfo {
		 display: inline-block;
		 padding-left: 20px;
		 vertical-align: top;
	}

	.memoHeaderCompanyInfoTable tr td {
		padding-left: 0px;
	}

	.memoHeaderTitle {
		border: 2px solid;
		font-size: 20pt;
		font-weight: bold;
		padding: 5px 100px;
		margin-top:10px;
	}

	.memoCustomer, .memoInfo {
		display: inline-block;
	}

	.memoInfo {
		float: right;
	}
	.memoInfoTable .memoInfoTableTitle{
		font-weight: bold;
		text-align: right;		
	}
	.memoInfoTable .memoInfoTableContent{
		text-align: left;		
	}
');
?>

<div style="width:100%;text-align: center;">
    <div class="memoHeaderTitle delivery">
        PACKING LIST
    </div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Packing List #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($packingList->number); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($packingList, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Warehouse</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($packingList, 'warehouse.name')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Order #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($packingList, 'orderHeader.number')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Cabang</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($packingList, 'branch.name')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($packingList, 'orderHeader.customer.name')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
        <th style="text-align: center; width: 3%">No.</th>
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center; width: 10%">Quantity</th>
        <th style="text-align: center; width: 10%">Unit</th>
    </tr>

	<?php //$grandTotalQuantity = 0; ?>
	<?php //$totalQuantityNewProduct = 0; ?>
    <?php $totalQuantity = 0; ?>
    <?php foreach ($packingList->packingListDetails as $i => $detail): ?>
        <?php $product = $detail->orderDetail->product; ?>
        <tr class="titems" style="border-bottom: 1px solid">
            <!--no-->
            <td style="text-align: center"><?php echo $i + 1; ?></td>
            <td><!--nama barang-->
                <?php echo CHtml::encode(CHtml::value($product, 'name')); ?>
            </td>
            <td style="text-align: center"><!--quantity-->
                <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
            </td>
            <td style="text-align: center"><!--unit-->
                <?php echo CHtml::encode(CHtml::value($product, 'unitIdSingle.name')); ?>
            </td>
        </tr>
        <?php $totalQuantity += $detail->quantity; ?>
    <?php endforeach; ?>

<!--    <tr id="theader">
        <th style="text-align: center; width: 3%"></th>
        <th style="text-align: center">Barang Non Stok</th>
        <th style="text-align: center; width: 10%"></th>
        <th style="text-align: center; width: 10%"></th>
    </tr>-->

    <?php /*foreach ($packingList->packingListDetails as $detail): ?> 
        <?php foreach ($detail->orderNewProducts as $i => $orderNewProduct): ?> 
            <tr class="titems">
                <!--no-->
                <td style="text-align: center">
                    <?php echo $i+1; ?>
                </td>

                <td><!--nama barang-->
                    <?php echo CHtml::encode(CHtml::value($orderNewProduct, 'name')); ?>
                </td>

                <td style="text-align: center"><!--quantity-->
                    <?php echo CHtml::encode(CHtml::value($orderNewProduct, 'quantity')); ?>
                </td>

                <td style="text-align: center"><!--unit-->
                    <?php echo CHtml::encode(CHtml::value($orderNewProduct, 'unit.name')); ?>
                </td>
            </tr>
            <?php $totalQuantityNewProduct += $orderNewProduct->quantity; ?>
        <?php endforeach; ?>
	<?php endforeach; ?>
    <?php $grandTotalQuantity = $totalQuantityNewProduct + $totalQuantity; */?>
            
    <tr class="titems">
        <td style="border-top: 2px solid; font-weight: bold; text-align: right" colspan="2">Total:</td>
        <td style="border-top: 2px solid; font-weight: bold; text-align: center">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?>
        </td>
        <td style="border-top: 2px solid;"></td>
    </tr>
</table>

<div>CATATAN: <?php echo CHtml::encode(CHtml::value($packingList, 'note')); ?></div>

<br/>

<div class="memosig">
    <div class="divtable" style="font-weight:bold; font-style: italic;">
        <div class="divtablecell sig1">
            <div></div>
        </div>
        <div class="divtablecell sig2">
            <div>Pengambil,</div>
        </div>
        <div class="divtablecell sig3">
            <div></div>
        </div>
    </div>
</div>