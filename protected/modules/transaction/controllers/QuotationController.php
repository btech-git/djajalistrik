<?php

class QuotationController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('quotationCreate') || Yii::app()->user->checkAccess('quotationEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'ajaxHtmlAddProduct' || $filterChain->action->id === 'ajaxHtmlRemoveDetail' || $filterChain->action->id === 'ajaxJsonCustomer' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'updateAllDiscount' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('quotationCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('quotationEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'report') {
            if (!(Yii::app()->user->checkAccess('quotationReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $quotation = $this->instantiate(null);
        $quotation->header->number = CodeNumber::make($quotation->header, 'number', 'QUO', Yii::app()->user);
        $quotation->header->admin_id = Yii::app()->user->id;
        $quotation->header->branch_id = Yii::app()->user->branch_id;

        $productCategoryMainId = isset($_GET['ProductCategoryMainId']) ? $_GET['ProductCategoryMainId'] : '';
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $dataProvider = $product->search();
        $dataProvider->criteria->with = array(
            'productCategoryIdSingle:resetScope' => array(
                'with' => array('productCategoryMain:resetScope'),
            ),
        );
        $dataProvider->criteria->compare('productCategoryMain.id', $productCategoryMainId);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $error = false;
        if (isset($_POST['Submit'])) {
            $this->loadState($quotation);
            if ($quotation->save(Yii::app()->db)) {
                Yii::app()->session['QuotationMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $quotation->header->id));
            } else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'quotation' => $quotation,
            'dataProvider' => $dataProvider,
            'productCategoryMainId' => $productCategoryMainId,
            'product' => $product,
            'customer' => $customer,
            'error' => $error,
        ));
    }

    public function actionUpdate($id) {
        $quotation = $this->instantiate($id);

        $quotation->header->admin_id = Yii::app()->user->id;

        $productCategoryMainId = isset($_GET['ProductCategoryMainId']) ? $_GET['ProductCategoryMainId'] : '';
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $dataProvider = $product->search();
        $dataProvider->criteria->with = array(
            'productCategoryIdSingle:resetScope' => array(
                'with' => array('productCategoryMain:resetScope'),
            ),
        );
        $dataProvider->criteria->compare('productCategoryMain.id', $productCategoryMainId);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $error = false;

        if (isset($_POST['Submit'])) {
            $this->loadState($quotation);
            if ($quotation->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $quotation->header->id));
            else
                $error = true;
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'quotation' => $quotation,
            'dataProvider' => $dataProvider,
            'productCategoryMainId' => $productCategoryMainId,
            'product' => $product,
            'customer' => $customer,
            'error' => $error,
        ));
    }

    public function actionView($id) {
        $quotationHeader = $this->loadModel($id);

        $customer = $quotationHeader->customer(array('scopes' => 'resetScope'));
        $discountCategory = $quotationHeader->customer(array('scopes' => 'resetScope'))->discountCategory(array('scopes' => 'resetScope'));
        $branch = $quotationHeader->branch(array('scopes' => 'resetScope'));

        $criteria = new CDbCriteria;
        $criteria->compare('quotation_header_id', $quotationHeader->id);
        $detailsDataProvider = new CActiveDataProvider('QuotationDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array(
            'product:resetScope',
            'unit:resetScope'
        );


        $this->render('view', array(
            'quotationHeader' => $quotationHeader,
            'customer' => $customer,
            'discountCategory' => $discountCategory,
            'branch' => $branch,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        if (!(Yii::app()->user->checkAccess('administrator'))) {
            if (!(isset(Yii::app()->session['QuotationMemoAllowed']) && Yii::app()->session['QuotationMemoAllowed'] === true))
                $this->redirect(array('admin'));
        }

        Yii::app()->session->remove('QuotationMemoAllowed');

        $quotation = $this->loadModel($id);

        $customer = $quotation->customer(array('scopes' => 'resetScope'));
        $discountCategory = $quotation->customer(array('scopes' => 'resetScope'))->discountCategory(array('scopes' => 'resetScope'));
        $branch = $quotation->branch(array('scopes' => 'resetScope'));

        $quotationDetails = $quotation->quotationDetails(array(
            'with' => array(
                'product:resetScope',
                'unit:resetScope'
            ),
        ));

        $this->render('memo', array(
            'quotation' => $quotation,
            'customer' => $customer,
            'discountCategory' => $discountCategory,
            'branch' => $branch,
            'quotationDetails' => $quotationDetails,
        ));
    }

    public function actionReport() {
        $quotationHeader = Search::bind(new QuotationHeader('search'), isset($_GET['QuotationHeader']) ? $_GET['QuotationHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $quotationReport = new QuotationReport($quotationHeader->search());
        $quotationReport->setupLoading();
        $quotationReport->setupPaging($pageSize, $currentPage);
        $quotationReport->setupSorting();
        $quotationReport->setupFilter($startDate, $endDate);

        $this->render('report', array(
            'quotationReport' => $quotationReport,
            'quotationHeader' => $quotationHeader,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAdmin() {
        $quotation = Search::bind(new QuotationHeader('search'), isset($_GET['QuotationHeader']) ? $_GET['QuotationHeader'] : array());

        $dataProvider = $quotation->search();

        $dataProvider->criteria->with = array(
            'customer:resetScope' => array(
                'with' => 'discountCategory:resetScope',
            ),
            'branch:resetScope',
        );

        $buttonTemplate = '{view}';
        if (Yii::app()->user->checkAccess('quotationEdit'))
            $buttonTemplate .= '{update}';
        if (Yii::app()->user->checkAccess('administrator'))
            $buttonTemplate .= '{delete}';

        $this->render('admin', array(
            'quotation' => $quotation,
            'dataProvider' => $dataProvider,
            'buttonTemplate' => $buttonTemplate,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $quotationHeader = $this->loadModel($id);
            if ($quotationHeader !== null) {
                $quotationHeader->is_inactive = !$quotationHeader->is_inactive;
                $quotationHeader->update(array('is_inactive'));
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotation = $this->instantiate($id);

            $this->loadState($quotation);

            if (isset($_POST['ProductId']))
                $quotation->addDetail($_POST['ProductId']);

            $this->renderPartial('_detail', array(
                'quotation' => $quotation,
                'error' => false,
            ));
        }
    }

    public function actionAjaxHtmlAddEmptyDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotation = $this->instantiate($id);

            $this->loadState($quotation);

            $detail = new QuotationDetail();
            $detail->unit_id = 1;
            $quotation->details[] = $detail;

            $this->renderPartial('_detail', array(
                'quotation' => $quotation,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['QuotationHeader']['customer_id'])) ? $_POST['QuotationHeader']['customer_id'] : '';

            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_company' => CHtml::value($customer, 'company'),
                'customer_address_1' => CHtml::value($customer, 'address_1'),
                'customer_city' => CHtml::value($customer, 'city'),
                'customer_discount_category' => CHtml::value($customer, 'discountCategory.name'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotation = $this->instantiate($id);

            $this->loadState($quotation);

            $quotation->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'quotation' => $quotation,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotation = $this->instantiate($id);

            $this->loadState($quotation);

//			if ($quotation->details[$index]->quantity >= $quotation->details[$index]->product->quantity_bulk)
//			{
//				if ($quotation->details[$index]->quantity % $quotation->details[$index]->product->quantity_bulk > 0)
//					$quotation->details[$index]->quantity = $quotation->details[$index]->product->quantity_bulk;
//				
//				$quotation->details[$index]->unit_id = $quotation->details[$index]->product->unit_id_bulk;
//			}
//			else
//				$quotation->details[$index]->unit_id = $quotation->details[$index]->product->unit_id_single;

            if ($quotation->details[$index]->unit_id !== $_POST['QuotationDetail'][$index]['unit_id'])
                $quotation->updateDiscountAt($index);

            $object = array(
                'quantity' => CHtml::value($quotation->details[$index], 'quantity'),
                'unit_id' => CHtml::value($quotation->details[$index], 'unit_id'),
                'unit_name' => CHtml::value($quotation->details[$index], 'unit.name'),
                'unit_price' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotation->details[$index], 'unit_price')),
                'discount_1' => CHtml::value($quotation->details[$index], 'discount_1'),
                'discount_2' => CHtml::value($quotation->details[$index], 'discount_2'),
                'discount_3' => CHtml::value($quotation->details[$index], 'discount_3'),
                'discount_4' => CHtml::value($quotation->details[$index], 'discount_4'),
                'discount_5' => CHtml::value($quotation->details[$index], 'discount_5'),
                'total' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotation->details[$index], 'total')),
                'grandTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotation, 'grandTotal')),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlUpdateAllDiscount($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotation = $this->instantiate($id);

            $this->loadState($quotation);

            $quotation->updateDiscount();

            $this->renderPartial('_detail', array(
                'quotation' => $quotation,
                'error' => false,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $quotation = new Quotation(new QuotationHeader(), array());
        else {
            $quotationHeader = $this->loadModel($id);
            $quotation = new Quotation($quotationHeader, $quotationHeader->quotationDetails(array('scopes' => 'resetScope')));
        }

        return $quotation;
    }

    public function loadModel($id) {
        $model = QuotationHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($quotation) {
        if (isset($_POST['QuotationHeader'])) {
            $quotation->header->attributes = $_POST['QuotationHeader'];
        }
        if (isset($_POST['QuotationDetail'])) {
            foreach ($_POST['QuotationDetail'] as $i => $item) {
                if (isset($quotation->details[$i]))
                    $quotation->details[$i]->attributes = $item;
                else {
                    $detail = new QuotationDetail();
                    $detail->attributes = $item;
                    $quotation->details[] = $detail;
                }
            }
            if (count($_POST['QuotationDetail']) < count($quotation->details))
                array_splice($quotation->details, $i + 1);
        } else
            $quotation->details = array();
    }

}

?>