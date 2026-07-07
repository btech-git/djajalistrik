<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $company
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $post_code
 * @property string $company_phone_1
 * @property string $company_phone_2
 * @property string $company_phone_3
 * @property string $company_phone_4
 * @property string $company_phone_5
 * @property string $company_fax_1
 * @property string $company_fax_2
 * @property string $email
 * @property string $tax_number
 * @property string $website
 * @property string $contact_person
 * @property string $contact_person_phone_1
 * @property string $contact_person_phone_2
 * @property string $contact_person_phone_3
 * @property string $contact_person_phone_4
 * @property string $contact_person_phone_5
 * @property string $contact_person_email
 * @property string $credit_limit
 * @property integer $discount_category_id
 * @property integer $salesman_id
 * @property integer $is_non_tax
 * @property integer $is_inactive
 * @property integer $payment_term
 *
 * @property Salesman $salesman
 * @property DiscountCategory $discountCategory
 * @property InvoiceTemporary[] $invoiceTemporaries
 * @property OrderHeader[] $orderHeaders
 * @property PurchaseHeader[] $purchaseHeaders
 * @property QuotationHeader[] $quotationHeaders
 * @property ReceiptTemporaryHeader[] $receiptTemporaryHeaders
 * @property SaleReceiptHeader[] $saleReceiptHeaders
 * @property InvoiceHeader[] $invoiceHeaders
 */
class CustomerBase extends ActiveRecord {

    public function tableName() {
        return 'tbldl_customer';
    }

    public function rules() {
        return array(
            array('name, discount_category_id, salesman_id', 'required'),
            array('email', 'email'),
            array('discount_category_id, salesman_id, is_non_tax, is_inactive, payment_term', 'numerical', 'integerOnly' => true),
            array('name, company, city, post_code, company_phone_1, company_phone_2, company_phone_3, company_phone_4, company_phone_5, company_fax_1, company_fax_2, email, tax_number, website, contact_person, contact_person_phone_1, contact_person_phone_2, contact_person_phone_3, contact_person_phone_4, contact_person_phone_5', 'length', 'max' => 60),
            array('contact_person_email', 'length', 'max' => 100),
            array('credit_limit', 'length', 'max' => 18),
            array('address_1, address_2', 'safe'),
            // The following rule is used by search().
            array('id, name, company, address_1, address_2, city, post_code, company_phone_1, company_phone_2, company_phone_3, company_phone_4, company_phone_5, company_fax_1, company_fax_2, email, tax_number, website, contact_person, contact_person_phone_1, contact_person_phone_2, contact_person_phone_3, contact_person_phone_4, contact_person_phone_5, contact_person_email, credit_limit, discount_category_id, salesman_id, is_non_tax, is_inactive, payment_term', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'salesman' => array(self::BELONGS_TO, 'Salesman', 'salesman_id'),
            'discountCategory' => array(self::BELONGS_TO, 'DiscountCategory', 'discount_category_id'),
            'invoiceTemporaries' => array(self::HAS_MANY, 'InvoiceTemporary', 'customer_id'),
            'orderHeaders' => array(self::HAS_MANY, 'OrderHeader', 'customer_id'),
            'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'customer_id'),
            'quotationHeaders' => array(self::HAS_MANY, 'QuotationHeader', 'customer_id'),
            'receiptTemporaryHeaders' => array(self::HAS_MANY, 'ReceiptTemporaryHeader', 'customer_id'),
            'saleReceiptHeaders' => array(self::HAS_MANY, 'SaleReceiptHeader', 'customer_id'),
            'invoiceHeaders' => array(self::HAS_MANY, 'InvoiceHeader', 'customer_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'company' => 'Company',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'city' => 'City',
            'post_code' => 'Post Code',
            'company_phone_1' => 'Company Phone 1',
            'company_phone_2' => 'Company Phone 2',
            'company_phone_3' => 'Company Phone 3',
            'company_phone_4' => 'Company Phone 4',
            'company_phone_5' => 'Company Phone 5',
            'company_fax_1' => 'Company Fax 1',
            'company_fax_2' => 'Company Fax 2',
            'email' => 'Email',
            'tax_number' => 'Tax Number',
            'website' => 'Website',
            'contact_person' => 'Contact Person',
            'contact_person_phone_1' => 'Contact Person Phone 1',
            'contact_person_phone_2' => 'Contact Person Phone 2',
            'contact_person_phone_3' => 'Contact Person Phone 3',
            'contact_person_phone_4' => 'Contact Person Phone 4',
            'contact_person_phone_5' => 'Contact Person Phone 5',
            'contact_person_email' => 'Contact Person Email',
            'credit_limit' => 'Credit Limit',
            'discount_category_id' => 'Discount Category',
            'salesman_id' => 'Salesman',
            'is_non_tax' => 'Is Non Tax',
            'is_inactive' => 'Is Inactive',
            'payment_term' => 'Payment Term (Days)',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('address_1', $this->address_1, true);
        $criteria->compare('address_2', $this->address_2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('post_code', $this->post_code, true);
        $criteria->compare('company_phone_1', $this->company_phone_1, true);
        $criteria->compare('company_phone_2', $this->company_phone_2, true);
        $criteria->compare('company_phone_3', $this->company_phone_3, true);
        $criteria->compare('company_phone_4', $this->company_phone_4, true);
        $criteria->compare('company_phone_5', $this->company_phone_5, true);
        $criteria->compare('company_fax_1', $this->company_fax_1, true);
        $criteria->compare('company_fax_2', $this->company_fax_2, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('tax_number', $this->tax_number, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('contact_person', $this->contact_person, true);
        $criteria->compare('contact_person_phone_1', $this->contact_person_phone_1, true);
        $criteria->compare('contact_person_phone_2', $this->contact_person_phone_2, true);
        $criteria->compare('contact_person_phone_3', $this->contact_person_phone_3, true);
        $criteria->compare('contact_person_phone_4', $this->contact_person_phone_4, true);
        $criteria->compare('contact_person_phone_5', $this->contact_person_phone_5, true);
        $criteria->compare('contact_person_email', $this->contact_person_email, true);
        $criteria->compare('credit_limit', $this->credit_limit, true);
        $criteria->compare('discount_category_id', $this->discount_category_id);
        $criteria->compare('salesman_id', $this->salesman_id);
        $criteria->compare('is_non_tax', $this->is_non_tax);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('payment_term', $this->payment_term);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
