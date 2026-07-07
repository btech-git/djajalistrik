<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/transaction/styles.css" />

        <script type='text/javascript' src='js/jquery.js'></script>
        <script type='text/javascript' src='js/jquery.cookie.js'></script>
        <script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
        <script type='text/javascript' src='js/jquery.dcjqaccordion.2.7.min.js'></script>
        <script type='text/javascript'>
            $(document).ready(function($){
                $('#accordion-1').dcAccordion({
                    eventType: 'click',
                    autoClose: true,
                    saveState: true,
                    disableLink: true,
                    speed: 'slow',
                    showCount: false,
                    autoExpand: false,
                    cookie	: 'dcjq-accordion-1',
                    classExpand	 : 'dcjq-current-parent'
                });
            });
        </script>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div id="page">
            <div id="login">
                <?php if (Yii::app()->user->isGuest):  ?>
                    <?php echo CHtml::link('Login', array('/site/login')); ?>
                <?php else: ?>
                    Welcome, <?php echo Yii::app()->user->name;?> | <?php echo CHtml::link('logout', array('/site/logout')); ?>
                <?php endif; ?>
            </div>
            <div id="header">
                <div id="logo" style="color: #cd0a0a; font-weight: bold">
                    <?php echo CHtml::image('images/logo djaja.jpg', 'Djaja Listrik'); ?> 
                    Inventory System
                </div>

            </div><!-- header -->
            <div id="body_left_column">
                <ul class="accordion" id="accordion-1">
                    <li class="dcjq-current-parent"><?php echo CHtml::link('DashBoard', array('/site/index')); ?></li>
                    <?php if (Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit') || Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit')): ?>
                        <li class="dcjq-current-parent"><a href="#">Penjualan Manual</a>
                            <ul>
                                <?php if (Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit')): ?>
                                    <li><?php echo CHtml::link('Invoice', array('/transaction/invoiceTemporary/admin')); ?></li>
                                <?php endif; ?>
                                <?php if (Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit')): ?>
                                    <li><?php echo CHtml::link('Tagihan Tanda Terima', array('/transaction/receiptTemporary/admin')); ?></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (Yii::app()->user->checkAccess('administrator')): ?>
                        <li class="dcjq-current-parent"><a href="#">Master</a>
                            <ul>
                                <li><?php echo CHtml::link('Data Perusahaan', array('/admin/branch/admin')); ?></li>
                                <li><?php echo CHtml::link('Data Pelanggan', array('/admin/customer/admin')); ?></li>
                                <li><?php echo CHtml::link('Data Supplier', array('/admin/supplier/admin')); ?></li>
                                <li><?php echo CHtml::link('Data Produk', array('/admin/product/admin')); ?></li>
                                <li><?php echo CHtml::link('Product Discount Category', array('/admin/productDiscountCategory/admin')); ?></li>
                                <li><?php echo CHtml::link('Chart of Account', array('/admin/account/admin')); ?></li>
                                <li><?php echo CHtml::link('Discount Category', array('/admin/discountCategory/admin')); ?></li>
                                <li><?php echo CHtml::link('Kategori Produk', array('/admin/productCategory/admin')); ?></li>
                                <li><?php echo CHtml::link('Kategori Produk Utama', array('/admin/productCategoryMain/admin')); ?></li>
                                <li><?php echo CHtml::link('Data Gudang', array('/admin/warehouse/admin')); ?></li>
                                <li><?php echo CHtml::link('Satuan', array('/admin/unit/admin')); ?></li>
                                <li><?php echo CHtml::link('Merk', array('/admin/brand/admin')); ?></li>
                                <li><?php echo CHtml::link('Salesman', array('/admin/salesman/admin')); ?></li>
                            </ul>
                        </li>
                        <li class="dcjq-current-parent"><?php echo CHtml::link('User Account', array('/admin/admin/admin')); ?></li>
                    <?php endif; ?>
                    <?php if (Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit') || Yii::app()->user->checkAccess('receiveCreate') || Yii::app()->user->checkAccess('receiveEdit') || Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit') || Yii::app()->user->checkAccess('adjustmentCreate') || Yii::app()->user->checkAccess('transferCreate') || Yii::app()->user->checkAccess('quotationCreate') || Yii::app()->user->checkAccess('quotationEdit') || Yii::app()->user->checkAccess('orderCreate') || Yii::app()->user->checkAccess('orderEdit') || Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit') || Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit') || Yii::app()->user->checkAccess('saleReturnCreate') || Yii::app()->user->checkAccess('saleReturnEdit')): ?>
                        <li class="dcjq-current-parent"><a href="#">Transaksi</a>
                            <ul>
                                <?php if (Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit') || Yii::app()->user->checkAccess('receiveCreate') || Yii::app()->user->checkAccess('receiveEdit') || Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Pembelian</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit')): ?>
                                                <li><?php echo CHtml::link('Purchase Order', array('/transaction/purchase/admin')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('receiveCreate') || Yii::app()->user->checkAccess('receiveEdit')): ?>
                                                <li><?php echo CHtml::link('Penerimaan Barang', array('/transaction/receive/admin')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit')): ?>
                                                <li><?php echo CHtml::link('Retur Pembelian', array('/transaction/purchaseReturn/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if (Yii::app()->user->checkAccess('adjustmentCreate') || Yii::app()->user->checkAccess('transferCreate')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Gudang</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('adjustmentCreate')): ?>
                                                <li><?php echo CHtml::link('Stok Adjustment', array('/transaction/adjustment/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('transferCreate')): ?>
                                                <li><?php echo CHtml::link('Stok Transfer', array('/transaction/transfer/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Stok Check', array('/report/stock/check')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if (Yii::app()->user->checkAccess('quotationCreate') || Yii::app()->user->checkAccess('quotationEdit') || Yii::app()->user->checkAccess('orderCreate') || Yii::app()->user->checkAccess('orderEdit') || Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit') || Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit') || Yii::app()->user->checkAccess('saleReturnCreate') || Yii::app()->user->checkAccess('saleReturnEdit')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Penjualan</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('quotationCreate') || Yii::app()->user->checkAccess('quotationEdit')): ?>
                                                <li><?php echo CHtml::link('Quotation', array('/transaction/quotation/admin')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('orderCreate') || Yii::app()->user->checkAccess('orderEdit')): ?>
                                                <li><?php echo CHtml::link('Sales Order', array('/transaction/order/admin')); ?></li>
                                                <li><?php echo CHtml::link('Packing List', array('/transaction/packingList/admin')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit')): ?>
                                                <li><?php echo CHtml::link('Pengiriman Barang', array('/transaction/delivery/admin')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('saleReturnCreate') || Yii::app()->user->checkAccess('saleReturnEdit')): ?>
                                                <li><?php echo CHtml::link('Retur Penjualan', array('/transaction/saleReturn/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (Yii::app()->user->checkAccess('purchaseReceiptCreate') || Yii::app()->user->checkAccess('purchasePaymentCreate') || Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('expenseCreate') || Yii::app()->user->checkAccess('depositCreate')): ?>
                        <li class="dcjq-current-parent"><a href="#">Keuangan</a>
                            <ul>
                                <?php if (Yii::app()->user->checkAccess('purchaseReceiptCreate') || Yii::app()->user->checkAccess('purchasePaymentCreate')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Pembelian</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('purchaseReceiptCreate') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Tanda Terima Pembelian', array('/transaction/purchaseReceipt/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>	
                                            <?php if (Yii::app()->user->checkAccess('purchasePaymentCreate') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Pembayaran Pembelian', array('/transaction/purchasePayment/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>	
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if (Yii::app()->user->checkAccess('salePaymentCreate')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Penjualan</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('invoiceCreate') || Yii::app()->user->checkAccess('invoiceEdit')): ?>
                                                <li><?php echo CHtml::link('Invoice', array('/transaction/invoice/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Tanda Terima Penjualan', array('/transaction/saleReceipt/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>	
                                            <?php if (Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Pembayaran Penjualan', array('/transaction/salePayment/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>	
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if (Yii::app()->user->checkAccess('expenseCreate') || Yii::app()->user->checkAccess('depositCreate')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Akuntansi</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('expenseCreate') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Penerimaan Kas / Bank', array('/transaction/deposit/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>	
                                            <?php if (Yii::app()->user->checkAccess('expenseCreate') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Pengeluaran Kas / Bank', array('/transaction/expense/admin'), array('target'=>'_blank')); ?></li>
                                            <?php endif; ?>	
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (Yii::app()->user->checkAccess('administrator')): ?>
                        <li class="dcjq-current-parent"><a href="#">Laporan</a>
                            <ul>
                                <?php //if (Yii::app()->user->checkAccess('purchase')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Pembelian</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('purchaseReport') || Yii::app()->user->checkAccess('purchase')): ?>
                                                <li><?php echo CHtml::link('Laporan Faktur Pajak Masukan', array('/report/purchaseTax/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Purchase Order', array('/report/purchase/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('receiveReport') || Yii::app()->user->checkAccess('purchase')): ?>
                                                <li><?php echo CHtml::link('Laporan Penerimaan Barang', array('/report/receive/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('purchaseReturnReport') || Yii::app()->user->checkAccess('purchase')): ?>
                                                <li><?php echo CHtml::link('Laporan Retur Pembelian', array('/report/purchaseReturn/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('purchaseReport')): ?>
                                                <li><?php echo CHtml::link('Laporan Pembelian Barang berdasarkan Produk', array('/report/purchaseItem/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Pembelian Barang berdasarkan Produk Baru', array('/report/purchaseNewItem/summary')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php //endif; ?>
                                <?php //if (Yii::app()->user->checkAccess('warehouse')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Gudang</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('adjustmentReport') || Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Laporan Stok Adjustment', array('/report/adjustment/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('transferReport')|| Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Laporan Stok Transfer', array('/report/transfer/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Laporan Stok Check', array('/report/stock/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Laporan Stok per Gudang', array('/report/stockLocal/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Laporan Stok Gudang Global', array('/report/stockGlobal/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('warehouse')): ?>
                                                <li><?php echo CHtml::link('Laporan Stok', array('/report/inventory/report')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php //endif; ?>
                                <?php //if (Yii::app()->user->checkAccess('sale')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Penjualan</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('orderReport') || Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Sales Order Summary', array('/report/orderSummary/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Sales Order', array('/report/order/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Sales Order Outstanding', array('/report/orderOutstanding/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Order Salesman', array('/report/orderSalesman/report')); ?></li>
                                            <?php endif; ?>
                                            <?php /*if (Yii::app()->user->checkAccess('quotationReport') || Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Quotation', array('/report/quotation/report')); ?></li>
                                            <?php endif;*/ ?>
                                            <?php if (Yii::app()->user->checkAccess('deliveryReport') || Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Pengiriman Barang', array('/report/delivery/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('invoiceReport') || Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Invoice Outstanding', array('/report/invoiceOutstanding/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Invoice Summary', array('/report/invoiceSummary/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Invoice Detail', array('/report/invoice/report')); ?></li>
                                            <?php endif; ?>
                                            <?php /*if (Yii::app()->user->checkAccess('saleReturnReport') || Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Retur Penjualan', array('/report/saleReturn/report')); ?></li>
                                            <?php endif;*/ ?>
                                            <?php if (Yii::app()->user->checkAccess('sale')): ?>
                                                <li><?php echo CHtml::link('Laporan Penjualan per Customer', array('/report/saleCustomer/report')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Penjualan per Produk', array('/report/saleItem/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('administrator')): ?>
                                                <li><?php echo CHtml::link('Salesman Performance', array('/report/monthlySalesmanSaleTransaction/summary')); ?></li>
                                                <li><?php echo CHtml::link('Admin Performance', array('/report/monthlyUserSaleTransaction/summary')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php //endif; ?>
                                <?php //if (Yii::app()->user->checkAccess('accounting')): ?>
                                    <li class="dcjq-current-parent"><a href="#">Keuangan</a>
                                        <ul>
                                            <?php if (Yii::app()->user->checkAccess('purchaseReceiptReport') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Laporan Pengeluaran Tanda Terima Pembelian', array('/report/purchaseReceipt/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('purchasePaymentReport') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Laporan Hutang Pembelian', array('/report/payable/summary')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Pembayaran Pembelian', array('/report/purchasePayment/report')); ?></li>
                                            <?php endif; ?>
                                            <?php /*if (Yii::app()->user->checkAccess('saleReceiptReport') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Laporan Penerimaan Tanda Terima Penjualan', array('/report/saleReceipt/report')); ?></li>
                                            <?php endif;*/ ?>
                                            <?php if (Yii::app()->user->checkAccess('salePaymentReport') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Laporan Piutang Penjualan', array('/report/receivable/summary')); ?></li>
                                                <li><?php echo CHtml::link('Laporan Pembayaran Penjualan', array('/report/salePayment/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('expenseReport') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Laporan Penerimaan Kas', array('/report/deposit/report')); ?></li>
                                            <?php endif; ?>
                                            <?php if (Yii::app()->user->checkAccess('depositReport') || Yii::app()->user->checkAccess('accounting')): ?>
                                                <li><?php echo CHtml::link('Laporan Pengeluaran Kas', array('/report/expense/report')); ?></li>
                                            <?php endif; ?>
                                            <li><?php //echo CHtml::link('Laporan Buku Kas / Bank', array('/transaction/bankBook/report')); ?></li>
                                            <li><?php //echo CHtml::link('Laporan Piutang Pelanggan', array('/transaction/agingSchedule/report')); ?></li>
                                        </ul>
                                    </li>
                                <?php //endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div style="width:1px;min-height: 800px;background-color:#C00;float:left; margin-left: 20px;">
                <div id="body_right_column">
                    <?php if(isset($this->breadcrumbs)):?>
                        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                            'homeLink'=>CHtml::link('Home', array('/site/index'))
                        )); ?><!-- breadcrumbs -->
                    <?php endif?>
                    <?php echo $content; ?>
                </div>
            </div>
            <div style="clear: both"></div>
            <hr style="width: 1250px"/>
            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> by PT. Djaja Listrik.<br/>
                All Rights Reserved.<br/>
                Powered by <?php echo CHtml::link('BloomingTech', 'http://www.bloomingtech.com'); ?>
            </div><!-- footer -->

        <!-- page -->
        </div>
    </body>
</html>
