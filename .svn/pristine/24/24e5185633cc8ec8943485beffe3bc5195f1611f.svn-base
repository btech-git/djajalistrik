<?php

/**
 * @property integer $id
 * @property string $name
 * @property integer $is_inactive
 *
 * @property AdjustmentDetail[] $adjustmentDetails
 * @property DeliveryDetail[] $deliveryDetails
 * @property Inventory[] $inventories
 * @property OrderDetail[] $orderDetails
 * @property OrderNewProduct[] $orderNewProducts
 * @property Product[] $products
 * @property Product[] $products1
 * @property PurchaseDetail[] $purchaseDetails
 * @property PurchaseNewProduct[] $purchaseNewProducts
 * @property PurchaseReturnDetail[] $purchaseReturnDetails
 * @property QuotationDetail[] $quotationDetails
 * @property ReceiveDetail[] $receiveDetails
 * @property SaleReturnDetail[] $saleReturnDetails
 * @property TransferDetail[] $transferDetails
 */
class UnitBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tbldl_unit';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, name, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'adjustmentDetails' => array(self::HAS_MANY, 'AdjustmentDetail', 'unit_id'),
			'deliveryDetails' => array(self::HAS_MANY, 'DeliveryDetail', 'unit_id'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'unit_id'),
			'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'unit_id'),
			'orderNewProducts' => array(self::HAS_MANY, 'OrderNewProduct', 'unit_id'),
			'products' => array(self::HAS_MANY, 'Product', 'unit_id_bulk'),
			'products1' => array(self::HAS_MANY, 'Product', 'unit_id_single'),
			'purchaseDetails' => array(self::HAS_MANY, 'PurchaseDetail', 'unit_id'),
			'purchaseNewProducts' => array(self::HAS_MANY, 'PurchaseNewProduct', 'unit_id'),
			'purchaseReturnDetails' => array(self::HAS_MANY, 'PurchaseReturnDetail', 'unit_id'),
			'quotationDetails' => array(self::HAS_MANY, 'QuotationDetail', 'unit_id'),
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'unit_id'),
			'saleReturnDetails' => array(self::HAS_MANY, 'SaleReturnDetail', 'unit_id'),
			'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'unit_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}