<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string $email
 * @property integer $branch_id
 * @property integer $is_inactive
 *
 * @property AdjustmentHeader[] $adjustmentHeaders
 * @property Branch $branch
 * @property DeliveryHeader[] $deliveryHeaders
 * @property DepositHeader[] $depositHeaders
 * @property ExpenseHeader[] $expenseHeaders
 * @property Inventory[] $inventories
 * @property Invoice[] $invoices
 * @property OrderHeader[] $orderHeaders
 * @property PackingListHeader[] $packingListHeaders
 * @property PurchaseHeader[] $purchaseHeaders
 * @property PurchasePaymentHeader[] $purchasePaymentHeaders
 * @property PurchaseReceiptHeader[] $purchaseReceiptHeaders
 * @property PurchaseReturnHeader[] $purchaseReturnHeaders
 * @property QuotationHeader[] $quotationHeaders
 * @property ReceiptTemporaryHeader[] $receiptTemporaryHeaders
 * @property ReceiveHeader[] $receiveHeaders
 * @property SalePaymentHeader[] $salePaymentHeaders
 * @property SaleReceiptHeader[] $saleReceiptHeaders
 * @property SaleReturnHeader[] $saleReturnHeaders
 * @property Taxform[] $taxforms
 * @property TransferHeader[] $transferHeaders
 */
class AdminBase extends ActiveRecord
{
	public $current_password = '';
    public $new_password = '';
    public $confirm_password = '';
    public $roles = array();
	
	public function tableName()
	{
		return 'tbldl_admin';
	}

	public function rules()
	{
		return array(
			array('name, username, branch_id', 'required'),
			array('email', 'email'),
			array('branch_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('name, username, phone, email', 'length', 'max'=>60),
			array('password', 'length', 'max'=>32),
			array('current_password, new_password, confirm_password', 'length', 'max' => 32),
            array('new_password, confirm_password', 'required', 'on' => 'insert'),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password'),
			array('roles', 'safe'),
			// The following rule is used by search().
			array('id, name, username, password, phone, email, branch_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'adjustmentHeaders' => array(self::HAS_MANY, 'AdjustmentHeader', 'admin_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'admin_id'),
			'depositHeaders' => array(self::HAS_MANY, 'DepositHeader', 'admin_id'),
			'expenseHeaders' => array(self::HAS_MANY, 'ExpenseHeader', 'admin_id'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'admin_id'),
			'invoices' => array(self::HAS_MANY, 'Invoice', 'admin_id'),
			'orderHeaders' => array(self::HAS_MANY, 'OrderHeader', 'admin_id'),
			'packingListHeaders' => array(self::HAS_MANY, 'PackingListHeader', 'admin_id'),
			'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'admin_id'),
			'purchasePaymentHeaders' => array(self::HAS_MANY, 'PurchasePaymentHeader', 'admin_id'),
			'purchaseReceiptHeaders' => array(self::HAS_MANY, 'PurchaseReceiptHeader', 'admin_id'),
			'purchaseReturnHeaders' => array(self::HAS_MANY, 'PurchaseReturnHeader', 'admin_id'),
			'quotationHeaders' => array(self::HAS_MANY, 'QuotationHeader', 'admin_id'),
			'receiptTemporaryHeaders' => array(self::HAS_MANY, 'ReceiptTemporaryHeader', 'admin_id'),
			'receiveHeaders' => array(self::HAS_MANY, 'ReceiveHeader', 'admin_id'),
			'salePaymentHeaders' => array(self::HAS_MANY, 'SalePaymentHeader', 'admin_id'),
			'saleReceiptHeaders' => array(self::HAS_MANY, 'SaleReceiptHeader', 'admin_id'),
			'saleReturnHeaders' => array(self::HAS_MANY, 'SaleReturnHeader', 'admin_id'),
			'taxforms' => array(self::HAS_MANY, 'Taxform', 'admin_id'),
			'transferHeaders' => array(self::HAS_MANY, 'TransferHeader', 'admin_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'username' => 'Username',
			'password' => 'Password',
			'phone' => 'Phone',
			'email' => 'Email',
			'branch_id' => 'Branch',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}