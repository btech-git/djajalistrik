<?php
$this->pageTitle=Yii::app()->name . ' - Djajalistrik';
$this->breadcrumbs=array(
	'Djajalistrik',
);
Yii::app()->clientScript->registerScript('transaction', "
	if (!document.getElementById('purchase-ul').getElementsByTagName('li').length)
		document.getElementById('purchase-fieldset').style.display = 'none';
	if (!document.getElementById('warehouse-ul').getElementsByTagName('li').length)
		document.getElementById('warehouse-fieldset').style.display = 'none';
	if (!document.getElementById('sale-ul').getElementsByTagName('li').length)
		document.getElementById('sale-fieldset').style.display = 'none';
	if (!document.getElementById('accounting-ul').getElementsByTagName('li').length)
		document.getElementById('accounting-fieldset').style.display = 'none';
");
?>
<h1>Laporan Transaksi</h1>

<div class="form">        
	<fieldset id="purchase-fieldset">
		<legend>Pembelian</legend>
		<ul id="purchase-ul" style="display: table-cell">
			<li> <?php echo CHtml::link('Purchase Order', array('/transaction/purchase/report')); ?></li><br/>
			<li> <?php echo CHtml::link('Penerimaan Barang', array('/transaction/receive/report')); ?></li><br/>
			<li> <?php echo CHtml::link('Retur Pembelian', array('/transaction/purchaseReturn/report')); ?></li><br/>
		</ul>
	</fieldset>
        
	<fieldset id="warehouse-fieldset">
		<legend>Gudang</legend>
		<ul id="warehouse-ul" style="display: table-cell">
			<li><?php echo CHtml::link('Stok Adjustment', array('/transaction/adjustment/report')); ?></li><br/>
			<li><?php echo CHtml::link('Stok per Gudang', array('/transaction/stockLocal/report')); ?></li><br/>
			<li><?php echo CHtml::link('Stok Gudang Global', array('/transaction/stockGlobal/report')); ?></li><br/>
			<li><?php echo CHtml::link('Stok Gudang Summary', array('/transaction/stock/report')); ?></li><br/>
			<li><?php echo CHtml::link('Stok', array('/transaction/inventory/report')); ?></li><br/>
			<li><?php echo CHtml::link('Stok Transfer', array('/transaction/transfer/report')); ?></li><br/>
		</ul>
	</fieldset>
        
	<fieldset id="sale-fieldset">
		<legend>Penjualan</legend>
		<ul id="sale-ul" style="display: table-cell">
			<li><?php echo CHtml::link('Sales Order', array('/transaction/order/report')); ?></li><br/>
			<li><?php echo CHtml::link('Quotation', array('/transaction/quotation/report')); ?></li><br/>
			<li><?php echo CHtml::link('Pengiriman Barang', array('/transaction/delivery/report')); ?></li><br/>
			<li><?php echo CHtml::link('Retur Penjualan', array('/transaction/saleReturn/report')); ?></li><br/>
			<li> <?php echo CHtml::link('Penjualan Barang', array('/transaction/invoice/report')); ?></li><br/>
			<li><?php echo CHtml::link('Penjualan Barang per Pelanggan (Summary)', array('/transaction/saleCustomer/report')); ?></li><br/>
			<li><?php echo CHtml::link('Penjualan Barang per Item (Summary)', array('/transaction/saleItem/report')); ?></li><br/>
		</ul>
	</fieldset>
        
	<fieldset id="accounting-fieldset">
		<legend>Keuangan</legend>
		<ul id="accounting-ul" style="display: table-cell">
			<li><?php echo CHtml::link('Daftar Piutang Pelanggan', array('/transaction/agingSchedule/report')); ?></li><br/>
			<li><?php echo CHtml::link('Buku Kas / Bank', array('/transaction/bankbook/report')); ?></li><br/>
			<li><?php echo CHtml::link('Pengeluaran Tanda Terima Pembelian', array('/transaction/purchaseReceipt/report')); ?></li><br/>
			<li><?php echo CHtml::link('Pembayaran Pembelian', array('/transaction/purchasePayment/report')); ?></li><br/>
			<li><?php echo CHtml::link('Penerimaan Tanda Terima Penjualan', array('/transaction/saleReceipt/report')); ?></li><br/>
			<li><?php echo CHtml::link('Pembayaran Penjualan', array('/transaction/salePayment/report')); ?></li><br/>
		</ul>
	</fieldset>
</div>
