<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <div class="container">
        <div class="span-11">
            <div class="row">
                <?php echo CHtml::label('P O #', false); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'number')); ?>
                <?php echo CHtml::error($purchase->header, 'number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $purchase->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchase->header, 'date'); ?>
            </div>

            <?php $purchaseOrder = $purchase->header->orderHeader(array('scopes' => 'resetScope')); ?>

            <div class="row">
                <?php echo CHtml::activeLabelEx($purchase->header, 'Cabang'); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'branch_id', CHtml::listData(Branch::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Branch --')) ?>
                <?php echo CHtml::error($purchase->header, 'branch_id'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('PPN / non-PPN', false); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'is_tax', array(
                    PurchaseHeader::TAX => PurchaseHeader::TAX_LITERAL, 
                    PurchaseHeader::NON_TAX => PurchaseHeader::NON_TAX_LITERAL
                ), array(
                    'empty' => '-- Pilih Status Tax --',
                    'onchange' => 'hide();hideTaxRow();' . CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => "JSON",
                        'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $purchase->header->id)),
                        'success' => 'function(data) {
                            $("#sub_total").html(data.subTotal);
                            $("#tax").html(data.tax);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($purchase->header, 'is_tax'); ?>
            </div>

            <div class="row" id="includeRow">
                <?php echo CHtml::label('Include', false); ?>
                <span id ="include">
                    <?php echo CHtml::activeDropDownList($purchase->header, 'is_include', array(
                        PurchaseHeader::INCLUDE_TAX => PurchaseHeader::INCLUDE_TAX_LITERAL, 
                        PurchaseHeader::NON_INCLUDE => PurchaseHeader::NON_INCLUDE_LITERAL
                    ), array(
                        'empty' => '-- Pilih Include --',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => "JSON",
                            'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $purchase->header->id)),
                            'success' => 'function(data) {
                                $("#sub_total").html(data.subTotal);
                                $("#tax").html(data.tax);
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                </span>
                <?php echo CHtml::error($purchase->header, 'is_include'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan Eksternal', ''); ?>
                <?php echo CHtml::activeTextArea($purchase->header, 'note_external', array('cols' => 30, 'rows' => 3)); ?>
                <?php echo CHtml::error($purchase->header, 'note_external'); ?>
            </div>
        </div>

        <div class="span-11 last">
            <div class="row">
                <?php echo CHtml::activeLabelEx($purchase->header, 'currency_id'); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'currency_id', CHtml::listData(Currency::model()->active()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Mata Uang --')); ?>
                <?php echo CHtml::error($purchase->header, 'currency_id'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Pemesanan #', ''); ?>
                <?php if ($purchase->header->isNewRecord): ?>
                    <?php echo CHtml::activeTextField($purchase->header, 'order_header_id', array('readonly' => true, 'onclick' => '$("#sale-header-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#sale-header-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'order_header_codeNumber')); ?>
                    <?php echo CHtml::encode(CHtml::value($purchase->header, 'orderHeader.codeNumber')); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                    <?php echo CHtml::error($purchase->header, 'order_header_id'); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'sale-header-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Sale Order',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>
                
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'sale-header-grid',
                        'dataProvider' => $orderDataProvider,
                        'filter' => $orderHeader,
                        'selectionChanged' => 'js:function(id) {
                            $("#' . CHtml::activeId($purchase->header, 'order_header_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#sale-header-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                $("#order_header_codeNumber").html("");
                                $("#customer_name_so").html("");
                                $("#customer_purchase_number").html("");
                                $("#SearchButton").show();
                            } else {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonOrder', array('id' => $purchase->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#order_header_codeNumber").html(data.order_header_codeNumber);
                                        $("#customer_name_so").html(data.customer_name);
                                        $("#customer_purchase_number").html(data.customer_purchase_number);
                                        $("#SearchButton").hide();
                                    },
                                });
                            }

                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlAddOrder', array('id' => $purchase->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                                                        
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlAddOrderNewProduct', array('id' => $purchase->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#new_product_div").html(html); },
                            });
                        }',
                        'columns' => array(
                            'number',
                            'reference_number: PO Customer',
                            array(
                                'header' => 'Tanggal',
                                'name' => 'date',
                                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                            ),
                            array(
                                'header' => 'Customer',
                                'name' => 'customer_id',
                                'filter' => CHtml::textField('CustomerName', $customerName, array('maxLength' => 60, 'size' => 10)),
                                'value' => 'CHtml::value($data, "customer.name")',
                            ),
                        ),
                    )); ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                <?php else: ?>
                    <?php $orderHeaderNumber = ($purchase->header->orderHeader === null) ? '' : $purchase->header->orderHeader->number; ?>
                    <?php echo CHtml::encode($orderHeaderNumber); ?>
                    <?php echo CHtml::activeHiddenField($purchase->header, 'order_header_id', array('value' => $purchase->header->order_header_id)); ?>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama Customer', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name_so')); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'orderHeader.customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('PO Customer', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_purchase_number')); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'orderHeader.reference_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <?php echo CHtml::activeTextField($purchase->header, 'supplier_id', array('readonly' => true, 'onclick' => '$("#supplier-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }')); ?>
                <?php echo CHtml::error($purchase->header, 'supplier_id'); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'supplier-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Supplier',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'supplier-grid',
                    'dataProvider' => $supplier->search(),
                    'filter' => $supplier,
                    'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($purchase->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#supplier-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#supplier_name").html("");
                            $("#supplier_address").html("");
                            $("#supplier_city").html("");
                            $("#supplier_phone").html("");
                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $purchase->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#supplier_name").html(data.supplier_name);
                                    $("#supplier_address").html(data.supplier_address);
                                    $("#supplier_city").html(data.supplier_city);
                                    $("#supplier_phone").html(data.supplier_phone);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        'company',
                        'address',
                        'phone',
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <?php $purchaseSupplier = $purchase->header->supplier(array('scopes' => 'resetScope')); ?>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseSupplier, 'name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Telpon', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_phone')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseSupplier, 'phone')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan Internal', ''); ?>
                <?php echo CHtml::activeTextArea($purchase->header, 'note_internal', array('cols' => 30, 'rows' => 3)); ?>
                <?php echo CHtml::error($purchase->header, 'note_internal'); ?>
            </div>
        </div>
    </div>

    <hr />

    <?php if ($purchase->header->order_header_id === null || $purchase->header->order_header_id === ''): ?>
        <div class="row">
            <?php echo CHtml::button('Cari Item', array('id' => 'SearchButton', 'name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
            <?php echo CHtml::hiddenField('ProductId'); ?>

            <?php echo CHtml::button('Tambah Produk Baru', array(
                'onclick' => CHtml::ajax(array(
                    'type' => 'POST',
                    'url' => CController::createUrl('ajaxHtmlAddNewProduct', array('id' => $purchase->header->id)),
                    'update' => '#new_product_div',
                )),
            )); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php echo CHtml::error($purchase->header, 'error'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('purchase' => $purchase, 'error' => $error)); ?>
    </div>

    <div id="new_product_div">
        <?php $this->renderPartial('_newProduct', array('purchase' => $purchase, 'error' => $error)); ?>
    </div>

    <table style="border: 1px solid; width: 950px">
        <tr style="background-color: #F5DEB3">
            <td style="text-align: right; font-weight: bold; width: 80%">Sub Total:</td>
            <td style="text-align: right; font-weight: bold">
                <span id="sub_total">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?>
                </span>
            </td>
            <td></td>
        </tr>

        <tr id="taxRow" style="background-color: #F5DEB3">
            <td style="text-align: right; font-weight: bold; width: 80%">PPN 11%:</td>
            <td style="text-align: right; font-weight: bold">
                <span id="tax">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->totalTax)); ?>
                </span>
            </td>
            <td></td>
        </tr>

        <tr style="background-color: #F5DEB3">
            <td style="text-align: right; font-weight: bold; width: 80%">Grand Total:</td>
            <td style="text-align: right; font-weight: bold">
                <span id="grand_total">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->grandTotal)); ?>
                </span>
            </td>
            <td></td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'product-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Products',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'product-grid',
        'dataProvider' => $productDataProvider,
        'filter' => $product,
        'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
        'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css'),
        'selectionChanged' => 'js:function(id) {
            $("#ProductId").val($.fn.yiiGridView.getSelection(id));
            $("#product-dialog").dialog("close");
            $.ajax({
                type: "POST",
                url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $purchase->header->id)) . '",
                data: $("form").serialize(),
                success: function(html) {
                    $("#detail_div").html(html);
                },
            });
        }',
        'columns' => array(
            'code',
            'name',
            array(
                'name' => 'selling_price',
                'value' => 'number_format($data->selling_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'name' => 'quantity_bulk',
                'header' => 'Quantity',
                'value' => 'number_format($data->quantity_bulk, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'name' => 'product_category_id_single',
                'header' => 'Category',
                'filter' => CHtml::dropDownList('ProductCategoryMainId', $productCategoryMainId, CHtml::listData(ProductCategoryMain::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '')),
                'value' => 'CHtml::value($data, "productCategoryIdSingle.productCategoryMain.name")',
            ),
            array(
                'name' => 'unit_id_single',
                'header' => 'Satuan',
                'filter' => CHtml::listData(Unit::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                'value' => 'CHtml::value($data, "unitIdSingle.name")',
            ),
        ),
    )); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>

<script>
    function hide() {
        var tax = document.getElementById("PurchaseHeader_is_tax"),
                include = document.getElementById("includeRow");

        if (tax.value == 0) {
            include.style.visibility = "visible";
        } else {
            include.style.visibility = "hidden";
        }
    }

    function hideTaxRow() {
        var tax = document.getElementById("PurchaseHeader_is_tax"),
                row = document.getElementById("taxRow");

        if (tax.value == 0) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
</script>
