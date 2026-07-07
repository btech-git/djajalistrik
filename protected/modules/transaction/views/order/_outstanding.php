<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 8% }
    .width1-6 { width: 6% }
    .width1-7 { width: 5% }
    .width1-8 { width: 8% }
    .width1-9 { width: 8% }
    .width1-10 { width: 8% }
    .width1-11 { width: 8% }
    .width1-12 { width: 8% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Djaja Listrik</div>
    <div style="font-size: larger">Outstanding Sales Order</div>
</div>

<br />

<table style="border: 1px solid">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">SO #</th>
            <th class="width1-2">Branch</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">PO Customer #</th>
            <th class="width1-6">Total (Rp)</th>
            <th class="width1-7">Note Internal</th>
            <th class="width1-8">PO #</th>
            <th class="width1-9">Pengiriman #</th>
            <th class="width1-10">Invoice #</th>
            <th class="width1-11">Total Invoice (Rp)</th>
            <th class="width1-12">User Input</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::link($header->number, array("view", "id"=>$header->id), array('target' => '_blank')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'branch.code')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($header, 'date'))); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5">
                    <?php echo CHtml::link(CHtml::value($header, 'reference_number'), array("view", "id"=>$header->id), array('target' => '_blank')); ?>
                </td>
                <td class="width1-6" style="text-align: right">
                    <?php echo number_format(CHtml::encode(CHtml::value($header, 'grandTotal')), 2); ?>
                </td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'note_internal')); ?></td>
                <td class="width1-8">
                    <?php $purchaseOrder = PurchaseHeader::model()->findByAttributes(array('order_header_id' => $header->id)); ?>
                    <?php echo CHtml::encode(CHtml::value($purchaseOrder, 'number')); ?>
                </td>
                <td class="width1-9">
                    <?php $delivery = DeliveryHeader::model()->findByAttributes(array('order_header_id' => $header->id)); ?>
                    <?php echo CHtml::encode(CHtml::value($delivery, 'number')); ?>
                </td>
                <td class="width1-10">
                    <?php $invoice = InvoiceHeader::model()->findByAttributes(array('order_header_id' => $header->id)); ?>
                    <?php echo CHtml::encode(CHtml::value($invoice, 'number')); ?>
                </td>
                <td class="width1-11" style="text-align: right">
                    <?php echo number_format(CHtml::encode(CHtml::value($header, 'totalInvoice')), 2); ?>
                </td>
                <td class="width1-12"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>