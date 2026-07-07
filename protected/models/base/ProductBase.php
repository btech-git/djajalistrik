<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property string $size
 * @property string $color
 * @property string $description
 * @property integer $quantity_bulk
 * @property integer $quantity_minimum
 * @property string $selling_price
 * @property string $purchase_percentage_1
 * @property string $purchase_percentage_2
 * @property string $purchase_percentage_3
 * @property string $purchase_percentage_4
 * @property string $purchase_percentage_5
 * @property integer $product_category_id_bulk
 * @property integer $product_category_id_single
 * @property integer $unit_id_bulk
 * @property integer $unit_id_single
 * @property integer $brand_id
 * @property integer $is_inactive
 *
 * @property AdjustmentDetail[] $adjustmentDetails
 * @property Inventory[] $inventories
 * @property OrderDetail[] $orderDetails
 * @property Unit $unitIdBulk
 * @property Unit $unitIdSingle
 * @property Brand $brand
 * @property ProductCategory $productCategoryIdBulk
 * @property ProductCategory $productCategoryIdSingle
 * @property PurchaseDetail[] $purchaseDetails
 * @property PurchaseReturnDetail[] $purchaseReturnDetails
 * @property QuotationDetail[] $quotationDetails
 * @property ReceiveDetail[] $receiveDetails
 * @property TransferDetail[] $transferDetails
 */
class ProductBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_product';
    }

    public function rules() {
        return array(
            array('quantity_bulk, quantity_minimum, product_category_id_bulk, product_category_id_single, unit_id_bulk, unit_id_single, brand_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('code, type, size, color', 'length', 'max' => 60),
            array('name', 'length', 'max' => 300),
            array('selling_price', 'length', 'max' => 18),
            array('purchase_percentage_1, purchase_percentage_2, purchase_percentage_3, purchase_percentage_4, purchase_percentage_5', 'length', 'max' => 10),
            array('description', 'safe'),
            // The following rule is used by search().
            array('id, code, name, type, size, color, description, quantity_bulk, quantity_minimum, selling_price, purchase_percentage_1, purchase_percentage_2, purchase_percentage_3, purchase_percentage_4, purchase_percentage_5, product_category_id_bulk, product_category_id_single, unit_id_bulk, unit_id_single, brand_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'adjustmentDetails' => array(self::HAS_MANY, 'AdjustmentDetail', 'product_id'),
            'inventories' => array(self::HAS_MANY, 'Inventory', 'product_id'),
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'product_id'),
            'unitIdBulk' => array(self::BELONGS_TO, 'Unit', 'unit_id_bulk'),
            'unitIdSingle' => array(self::BELONGS_TO, 'Unit', 'unit_id_single'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'productCategoryIdBulk' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id_bulk'),
            'productCategoryIdSingle' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id_single'),
            'purchaseDetails' => array(self::HAS_MANY, 'PurchaseDetail', 'product_id'),
            'purchaseReturnDetails' => array(self::HAS_MANY, 'PurchaseReturnDetail', 'product_id'),
            'quotationDetails' => array(self::HAS_MANY, 'QuotationDetail', 'product_id'),
            'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'product_id'),
            'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'product_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'type' => 'Type',
            'size' => 'Size',
            'color' => 'Color',
            'description' => 'Description',
            'quantity_bulk' => 'Quantity Bulk',
            'quantity_minimum' => 'Quantity Minimum',
            'selling_price' => 'Selling Price',
            'purchase_percentage_1' => 'Purchase Percentage 1',
            'purchase_percentage_2' => 'Purchase Percentage 2',
            'purchase_percentage_3' => 'Purchase Percentage 3',
            'purchase_percentage_4' => 'Purchase Percentage 4',
            'purchase_percentage_5' => 'Purchase Percentage 5',
            'product_category_id_bulk' => 'Product Category Id Bulk',
            'product_category_id_single' => 'Product Category Id Single',
            'unit_id_bulk' => 'Unit Id Bulk',
            'unit_id_single' => 'Unit Id Single',
            'brand_id' => 'Brand',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('quantity_bulk', $this->quantity_bulk);
        $criteria->compare('quantity_minimum', $this->quantity_minimum);
        $criteria->compare('selling_price', $this->selling_price, true);
        $criteria->compare('purchase_percentage_1', $this->purchase_percentage_1, true);
        $criteria->compare('purchase_percentage_2', $this->purchase_percentage_2, true);
        $criteria->compare('purchase_percentage_3', $this->purchase_percentage_3, true);
        $criteria->compare('purchase_percentage_4', $this->purchase_percentage_4, true);
        $criteria->compare('purchase_percentage_5', $this->purchase_percentage_5, true);
        $criteria->compare('product_category_id_bulk', $this->product_category_id_bulk);
        $criteria->compare('product_category_id_single', $this->product_category_id_single);
        $criteria->compare('unit_id_bulk', $this->unit_id_bulk);
        $criteria->compare('unit_id_single', $this->unit_id_single);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
