<?php
Yii::app()->clientScript->registerScript('report', '
        $("#header").addClass("hide");
		$("#login").addClass("hide");
        $(".breadcrumbs").addClass("hide");
        $("#footer").addClass("hide");
		$("#body_left_column").addClass("hide");
        
        $("#AccountId").val("'.$accountId.'");
        $("#StartDate").val("'.$startDate.'");
        $("#EndDate").val("'.$endDate.'");
        $("#PageSize").val("'.$dataProvider->pagination->pageSize.'");
        $("#CurrentPage").val("'.($dataProvider->pagination->getCurrentPage(false) + 1).'");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/transaction/report.css');
?>
<div id="detail_div">
	<div class="hide">
        <div class="form" style="text-align: center">

        <?php echo CHtml::beginForm(array(''), 'get'); ?>
                
                <div class="row" style="background-color: #FFF8DC">
                        Account
                        <?php echo CHtml::dropDownlist('AccountId', '', CHtml::listData(Account::model()->findAll('account_category_id = 1'), 'id', 'name')); ?>
                </div>
                
                <div class="row">
                        Jumlah per Halaman
                        <?php echo CHtml::textField('PageSize', '', array('size'=>3)); ?>

                        Halaman saat ini
                        <?php echo CHtml::textField('CurrentPage', '', array('size'=>3)); ?>
                </div>
                
                <div class="row">
                        Tanggal Mulai
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name'=>'StartDate',
                                'options'=>array(
                                        'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                                        'readonly'=>true,
                                ),
                        )); ?>

                        Sampai
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name'=>'EndDate',
                                'options'=>array(
                                        'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                                        'readonly'=>true,
                                ),
                        )); ?>
                </div>

                <div class="row button">
                        <?php echo CHtml::submitButton('Show'); ?>
                        <?php echo CHtml::resetButton('Clear'); ?>
                </div>
                
        <?php echo CHtml::endForm(); ?>

        </div>

        <hr />
        
        <div class="right"><?php echo ReportHelper::summaryText($dataProvider); ?></div>
        <div class="clear"></div>
	</div>

	<div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">PT. DJAJALISTRIK</div>
        <div style="font-size: larger">Laporan Buku Bank</div>
        <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
	</div>

	<br />

	<table style="width: 90%; margin: 0 auto; border-spacing: 0pt">
        <tr>
                <th style="width: 25%; text-align: center; font-size: larger; border-bottom: 1px solid">Tanggal</th>
                <th style="width: 25%; text-align: center; font-size: larger; border-bottom: 1px solid">Account</th>
                <th style="width: 25%; text-align: center; font-size: larger; border-bottom: 1px solid">Debit</th>
                <th style="width: 25%; text-align: center; font-size: larger; border-bottom: 1px solid">Credit</th>
        </tr>
        <?php foreach ($dataProvider->data as $data): ?>
                <tr>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($data['date']))); ?></td>
                        <td><?php echo CHtml::encode($data['account']); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $data['debit'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $data['credit'])); ?></td>
                </tr>
        <?php endforeach; ?>
	</table>

	<br />

	<div class="hide">
        <div class="right">
                <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
						'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
                        'pages'=>$dataProvider->pagination,
                        'itemCount'=>$dataProvider->pagination->itemCount,
                        'pageSize'=>$dataProvider->pagination->pageSize,
                        'currentPage'=>$dataProvider->pagination->getCurrentPage(false),
                )); ?>
        </div>
        <div class="clear"></div>
	</div>
</div>