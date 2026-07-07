<?php
$this->breadcrumbs = array(
	'Customers'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Customer', 'url'=>array('create')),
	array('label'=>'Update Customer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);
?>

<h1>View Customer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/transaction/styles.css',
	'attributes'=>array(
		'id',
		'name',
		'company',
		'address_1',
		'address_2',
		'city',
		'post_code',
		'company_phone_1',
		'company_phone_2',
		'company_phone_3',
		'company_phone_4',
		'company_phone_5',
		'company_fax_1',
		'company_fax_2',
		'email',
		'tax_number',
		'website',
		'contact_person',
		'contact_person_phone_1',
		'contact_person_phone_2',
		'contact_person_phone_3',
		'contact_person_phone_4',
		'contact_person_phone_5',
		'contact_person_email',
		array(
			'label'=>'Payment Term (days)',
			'value'=>$model->payment_term,
		),
		array(
			'label'=>'Credit Limit',
			'value'=>number_format($model->credit_limit, 2),
		),
		array(
			'label'=>'Remaining Credit',
			'value'=>number_format($model->remainingCreditLimit, 2),
		),
		array(
			'label'=>'Discount Category',
			'value'=>($model->discountCategory === null) ? '' : $model->discountCategory->name,
		),
		array(
			'label'=>'Salesman',
			'value'=>($model->salesman === null) ? '' : $model->salesman->name,
		),
		array(
			'label'=>'Status',
			'value'=>$model->status(),
		),
	),
)); ?>
