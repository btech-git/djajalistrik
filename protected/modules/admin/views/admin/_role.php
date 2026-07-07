<table>
	<tr>
		<td>
			<?php echo CHtml::checkBox("Admin[roles][administrator]", CHtml::resolveValue($model, "roles[administrator]"), array('id'=>'Admin_roles_' . $counter, 'value'=>'administrator')); ?>
			<?php echo CHtml::label('Administrator', 'Admin_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
		<td>
			<?php echo CHtml::checkBox("Admin[roles][purchase]", CHtml::resolveValue($model, "roles[purchase]"), array('id'=>'Admin_roles_' . $counter, 'value'=>'purchase')); ?>
			<?php echo CHtml::label('Purchase', 'Admin_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
		<td>
			<?php echo CHtml::checkBox("Admin[roles][sale]", CHtml::resolveValue($model, "roles[sale]"), array('id'=>'Admin_roles_' . $counter, 'value'=>'sale')); ?>
			<?php echo CHtml::label('Sale', 'Admin_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
		<td>
			<?php echo CHtml::checkBox("Admin[roles][accounting]", CHtml::resolveValue($model, "roles[accounting]"), array('id'=>'Admin_roles_' . $counter, 'value'=>'accounting')); ?>
			<?php echo CHtml::label('Accounting', 'Admin_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
		<td>
			<?php echo CHtml::checkBox("Admin[roles][warehouse]", CHtml::resolveValue($model, "roles[warehouse]"), array('id'=>'Admin_roles_' . $counter, 'value'=>'warehouse')); ?>
			<?php echo CHtml::label('Warehouse', 'Admin_roles_' . $counter++, array('style'=>'display: inline')); ?>
		</td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Purchase</th>
		<th style="text-align: center">Create</th>
		<th style="text-align: center">Report</th>
		<th style="text-align: center">Edit</th>
	</tr>
	<tr>
		<td>Purchase</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseCreate]", CHtml::resolveValue($model, "roles[purchaseCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReport]", CHtml::resolveValue($model, "roles[purchaseReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseEdit]", CHtml::resolveValue($model, "roles[purchaseEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseEdit')); ?></td>
	</tr>
	<tr>
		<td>Receive</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][receiveCreate]", CHtml::resolveValue($model, "roles[receiveCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'receiveCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][receiveReport]", CHtml::resolveValue($model, "roles[receiveReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'receiveReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][receiveEdit]", CHtml::resolveValue($model, "roles[receiveEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'receiveEdit')); ?></td>
	</tr>
	<tr>
		<td>Purchase Return</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReturnCreate]", CHtml::resolveValue($model, "roles[purchaseReturnCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReturnCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReturnReport]", CHtml::resolveValue($model, "roles[purchaseReturnReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReturnReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReturnEdit]", CHtml::resolveValue($model, "roles[purchaseReturnEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReturnEdit')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Sale</th>
		<th style="text-align: center">Create</th>
		<th style="text-align: center">Report</th>
		<th style="text-align: center">Edit</th>
	</tr>
	<tr>
		<td>Sales Order</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][rderCreate]", CHtml::resolveValue($model, "roles[orderCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'orderCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][orderReport]", CHtml::resolveValue($model, "roles[orderReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'orderReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][orderEdit]", CHtml::resolveValue($model, "roles[orderEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'orderEdit')); ?></td>
	</tr>
	<tr>
		<td>Quotation</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][quotationCreate]", CHtml::resolveValue($model, "roles[quotationCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'quotationCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][quotationReport]", CHtml::resolveValue($model, "roles[quotationReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'quotationReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][quotationEdit]", CHtml::resolveValue($model, "roles[quotationEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'quotationEdit')); ?></td>
	</tr>
	<tr>
		<td>Delivery</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][deliveryCreate]", CHtml::resolveValue($model, "roles[deliveryCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'deliveryCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][deliveryReport]", CHtml::resolveValue($model, "roles[deliveryReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'deliveryReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][deliveryEdit]", CHtml::resolveValue($model, "roles[deliveryEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'deliveryEdit')); ?></td>
	</tr>
	<tr>
		<td>Sales Invoice</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][invoiceCreate]", CHtml::resolveValue($model, "roles[invoiceCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'invoiceCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][invoiceReport]", CHtml::resolveValue($model, "roles[invoiceReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'invoiceReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][invoiceEdit]", CHtml::resolveValue($model, "roles[invoiceEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'invoiceEdit')); ?></td>
	</tr>
	<tr>
		<td>Sales Return</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][saleReturnCreate]", CHtml::resolveValue($model, "roles[saleReturnCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'saleReturnCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][saleReturnReport]", CHtml::resolveValue($model, "roles[saleReturnReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'saleReturnReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][saleReturnEdit]", CHtml::resolveValue($model, "roles[saleReturnEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'saleReturnEdit')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Accounting</th>
		<th style="text-align: center">Create</th>
		<th style="text-align: center">Report</th>
		<th style="text-align: center">Edit</th>
	</tr>
	<tr>
		<td>Deposit</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][depositCreate]", CHtml::resolveValue($model, "roles[depositCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'depositCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][depositReport]", CHtml::resolveValue($model, "roles[depositReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'depositReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][depositEdit]", CHtml::resolveValue($model, "roles[depositEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'depositEdit')); ?></td>
	</tr>
	<tr>
		<td>Expense</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][expenseCreate]", CHtml::resolveValue($model, "roles[expenseCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'expenseCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][expenseReport]", CHtml::resolveValue($model, "roles[expenseReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'expenseReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][expenseEdit]", CHtml::resolveValue($model, "roles[expenseEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'expensetEdit')); ?></td>
	</tr>
	<tr>
		<td>Purchase Receipt</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReceiptCreate]", CHtml::resolveValue($model, "roles[purchaseReceiptCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReceiptCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReceiptReport]", CHtml::resolveValue($model, "roles[purchaseReceiptReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReceiptReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchaseReceiptEdit]", CHtml::resolveValue($model, "roles[purchaseReceiptEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchaseReceiptEdit')); ?></td>
	</tr>
	<tr>
		<td>Purchase Payment</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchasePaymentCreate]", CHtml::resolveValue($model, "roles[purchasePaymentCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchasePaymentCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchasePaymentReport]", CHtml::resolveValue($model, "roles[purchasePaymentReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchasePaymentReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][purchasePaymentEdit]", CHtml::resolveValue($model, "roles[purchasePaymentEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'purchasePaymentEdit')); ?></td>
	</tr>
	
	<tr>
		<td>Sales Receipt</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][saleReceiptCreate]", CHtml::resolveValue($model, "roles[saleReceiptCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'saleReceiptCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][saleReceiptReport]", CHtml::resolveValue($model, "roles[saleReceiptReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'saleReceiptReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][saleReceiptEdit]", CHtml::resolveValue($model, "roles[saleReceiptEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'saleReceiptEdit')); ?></td>
	</tr>
	<tr>
		<td>Sales Payment</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][salePaymentCreate]", CHtml::resolveValue($model, "roles[salePaymentCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'salePaymentCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][salePaymentReport]", CHtml::resolveValue($model, "roles[salePaymentReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'salePaymentReport')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][salePaymentEdit]", CHtml::resolveValue($model, "roles[salePaymentEdit]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'salePaymentEdit')); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th style="text-align: center; width: 50%">Warehouse</th>
		<th style="text-align: center">Create</th>
		<th style="text-align: center">Report</th>
		<th style="text-align: center"> &nbsp; &nbsp; &nbsp; </th>
	</tr>
	<tr>
		<td>Stok Adjustment</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][adjusmentCreate]", CHtml::resolveValue($model, "roles[adjustmentCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'adjustmentCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][adjustmentReport]", CHtml::resolveValue($model, "roles[adjustmentReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'adjustmentReport')); ?></td>
		<td></td>
	</tr>
	<tr>
		<td>Stok Transfer</td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][transferCreate]", CHtml::resolveValue($model, "roles[transferCreate]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'transferCreate')); ?></td>
		<td style="text-align: center"><?php echo CHtml::checkBox("Admin[roles][transferReport]", CHtml::resolveValue($model, "roles[transferReport]"), array('id'=>'Admin_roles_' . $counter++, 'value'=>'transferReport')); ?></td>
		<td></td>
	</tr>
</table>
