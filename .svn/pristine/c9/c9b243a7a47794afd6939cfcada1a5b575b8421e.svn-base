<?php
$this->breadcrumbs=array(
	'Deposit'=>array('/transaction/deposit/create'),
	'View',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$deposit,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'attributes'=>array(
			array(
				'label'=>'Pemasukan #',
				'value'=>$deposit->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $deposit->date),
			),
			array(
				'label'=>'Akun',
				'value'=>$account->name,
			),
			array(
				'label'=>'Catatan',
				'value'=>$deposit->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'deposit-detail-grid',
		'dataProvider'=>$detailsDataProvider,
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'columns'=>array(
			'description: Description',
			array(
				'header'=>'Jumlah',
				'value'=>'number_format($data->amount, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			'memo: Memo',
		),
	)); ?>
	<div id="link">
		<?php echo CHtml::link('Create', array('create')); ?>
		<?php echo CHtml::link('Update', array('update', 'id'=>$deposit->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$deposit->id), array('target'=>'_blank')); ?>
	</div>
</div>