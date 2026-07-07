<?php
$this->pageTitle=Yii::app()->name . ' - Djaja Listrik';
$this->breadcrumbs=array(
	'Djaja Listrik',
);
?>
<h1>Halaman Master</h1>

<div class="form">        
	<fieldset>
		<legend>Data Master</legend>
		<ul style="display: table-cell">
			<li><?php echo CHtml::link('Data Perusahaan', array('/admin/branch/admin'), array('target'=>'_blank')); ?></li><br/>
			<li><?php echo CHtml::link('Data Pelanggan', array('/admin/customer/admin'), array('target'=>'_blank')); ?></li><br/>
			<li><?php echo CHtml::link('Data Supplier', array('/admin/supplier/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Data Produk', array('/admin/product/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Data Gudang', array('/admin/warehouse/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Chart of Account', array('/admin/account/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Discount Category', array('/admin/discountCategory/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Kategori Produk', array('/admin/productCategory/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Product Discount Category', array('/admin/productDiscountCategory/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Unit', array('/admin/unit/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Merk', array('/admin/brand/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Group', array('/admin/productGroup/admin')); ?></li><br/>
			<li><?php echo CHtml::link('Currency', array('/admin/currency/admin')); ?></li><br/>
		</ul>
	</fieldset>
</div>
