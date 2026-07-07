<style>
	table
	{
		margin-bottom: 0px;
	}
</style>

<h1>View Packing List</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$packingList,
	'attributes'=>array(
		array(
			'label'=>'Packing List #',
			'value'=>$packingList->number,
		),
		array(
			'label'=>'Tanggal',
			'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $packingList->date),
		),
		array(
			'label'=>'Order #',
			'value'=>$packingList->orderHeader->number,
		),
		array(
			'label'=>'Customer',
			'value'=>$packingList->orderHeader->customer->name,
		),
		array(
			'label'=>'Gudang',
			'value'=>$packingList->warehouse->name,
		),
		array(
			'label'=>'Cabang',
			'value'=>$packingList->branch->name,
		),
		array(
			'label'=>'Catatan',
			'value'=>$packingList->note,
		),
	),
)); ?>

<br/>

<table class="memo">
	<tr id="theader">
		<th style="text-align: center; width: 3%">No.</th>
		<th style="text-align: center">Nama Barang</th>
		<th style="text-align: center; width: 15%">Quantity</th>
		<th style="text-align: center; width: 15%">Unit</th>
	</tr>
        
	<?php $grandTotalQuantity = 0; ?>
	<?php $totalQuantityNewProduct = 0; ?>
	<?php $totalQuantity = 0; ?>
	<?php foreach ($packingList->packingListDetails as $i => $detail): ?>
		<tr class="titems">
			<!--no-->
			<td style="text-align: center">
				<?php echo $i+1; ?>
			</td>
			
			<td><!--nama barang-->
				<?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.product_name')); ?>
			</td>
			
			<td style="text-align: center"><!--quantity-->
				<?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
			</td>

			<td style="text-align: center"><!--unit-->
				<?php echo CHtml::encode(CHtml::value($detail, 'orderDetail.unit.name')); ?>
			</td>
		</tr>
		<?php $totalQuantity += $detail->quantity; ?>
	<?php endforeach; ?>
		
<!--	<tr id="theader">
		<th style="text-align: center; width: 3%">No.</th>
		<th style="text-align: center">Barang Non Stok</th>
		<th style="text-align: center; width: 15%">Quantity</th>
		<th style="text-align: center; width: 15%">Unit</th>
	</tr>-->
        
    <?php /*foreach ($packingList->packingListDetails as $detail): ?> 
        <?php foreach ($detail->orderHeader->orderNewProducts as $i => $orderNewProduct): ?> 
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
		<td style="border-top: 2px solid;" ></td>
	</tr>
</table>
<br />

<div id="link">
	<?php echo CHtml::link('Create', array('create')); ?>
	<?php echo CHtml::link('Manage', array('admin')); ?>
	<?php echo CHtml::link('Print', array('memo', 'id'=>$packingList->id), array('target'=>'_blank')); ?>
</div>