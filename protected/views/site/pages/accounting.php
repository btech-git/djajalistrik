<?php
$this->pageTitle = Yii::app()->name . ' - Djaja Listrik';
$this->breadcrumbs = array(
	'Djaja Listrik',
);
?>
<h1>Keuangan</h1>

<div class="form">        
	<fieldset>
		<legend>Pembelian</legend>
		<ul style="display: table-cell">
			<li><?php echo CHtml::link('Pengeluaran Tanda Terima Pembelian', array('/transaction/purchaseReceipt/create')); ?></li><br/>
			<li><?php echo CHtml::link('Pembayaran Pembelian', array('/transaction/purchasePayment/create')); ?></li><br/>
		</ul>
	</fieldset>
	<fieldset>
		<legend>Penjualan</legend>
		<ul style="display: table-cell">
			<li><?php echo CHtml::link('Penerimaan Tanda Terima Penjualan', array('/transaction/saleReceipt/create')); ?></li><br/>
			<li><?php echo CHtml::link('Pembayaran Penjualan', array('/transaction/salePayment/create')); ?></li><br/>
		</ul>
	</fieldset>
	<fieldset>
		<legend>Akuntansi</legend>
		<ul style="display: table-cell">
			<li><?php echo CHtml::link('Penerimaan Kas / Bank', array('/transaction/deposit/create')); ?></li><br/>
			<li><?php echo CHtml::link('Pengeluaran Kas / Bank', array('/transaction/expense/create')); ?></li><br/>
		</ul>
	</fieldset>
</div>