<?php
$this->breadcrumbs=array(
	'Expense'=>array('/transaction/expense/create'),
	'View',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
		'data'=>$expense,
		'attributes'=>array(
			array(
				'label'=>'Pengeluaran #',
				'value'=>$expense->number,
			),
			array(
				'label'=>'Tanggal',
				'value'=>Yii::app()->dateFormatter->format("d MMMM yyyy", $expense->date),
			),
			array(
				'label'=>'Akun',
				'value'=>$account->name,
			),
			array(
				'label'=>'Catatan',
				'value'=>$expense->note,
			),
		),
	)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'expense-detail-grid',
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
		<?php echo CHtml::link('Update', array('update', 'id'=>$expense->id)); ?>
		<?php echo CHtml::link('Print', array('memo', 'id'=>$expense->id), array('target'=>'_blank')); ?>
	</div>
</div>