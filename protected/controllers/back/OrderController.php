<?php

class OrderController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction='admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

   
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Order;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
                /* test products */
            $products_details = array(
                array('product_id' => 55, 'anchor' => 'test anchor3', 'comment' => 'test comment3', 'url' => 'https://www.google.ca/search?q=yii+clientScript&ie=utf-8&oe=utf-8&aq=t&rls=org.mozilla:en-US:official&client=firefox-a&channel=sb&gfe_rd=cr&ei=IbKCVOKrLsaC8QenkYDoBg'),
                array('product_id' => 54, 'anchor' => 'test anchor1', 'comment' => 'test comment1', 'url' => 'https://www.google.ca/search?q=yii+clientScript&ie=utf-8&oe=utf-8&aq=t&rls=org.mozilla:en-US:official&client=firefox-a&channel=sb&gfe_rd=cr&ei=IbKCVOKrLsaC8QenkYDoBg'),
                array('product_id' => 57, 'anchor' => 'test anchor2', 'comment' => 'test comment2', 'url' => 'https://www.google.ca/search?q=yii+clientScript&ie=utf-8&oe=utf-8&aq=t&rls=org.mozilla:en-US:official&client=firefox-a&channel=sb&gfe_rd=cr&ei=IbKCVOKrLsaC8QenkYDoBg'),
            );
            /**/
            $total = 0;
            
            foreach($products_details as $k=>$p) {
                $products_details[$k]['model'] = Product::model()->findByPk($p['product_id']);
                $total+=$products_details[$k]['model']->price;
            }
            $model->total = $total;
            
			if($model->save()) {
                $task_date = 0;
                foreach($products_details as $p) {
                    $o2p = new OrderToProduct;
                    $o2p->attributes = $p;
                    $o2p->order_id = $model->id;
                    $o2p->price = $p['model']->price;
                    
                    $task_date = $this->getIntervalDate($task_date, $model->time_interval);
                    $o2p->task_date = date('Y-m-d', $task_date);
                    $o2p->save();
                }
                
                // update user statistics
                $user = User::model()->findByPk($model->user_id);
                $user->orders_num += 1;
                $user->websites_num += count($products_details);
                $user->update();
               
				$this->redirect(array('admin','id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    
    public function getIntervalDate($date_from, $interval)
    {
        //if first task
        if (!$date_from) {
            $date_from = time();
            $interval = 1;
        }
        
        $potential_date = $date_from + $interval * 24 * 3600/* 24 * 3600 seconds in day*/;
        
        return in_array(date('D', $potential_date), array('Sun')) ? $this->getIntervalDate($potential_date, 1) : $potential_date;
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
		if(isset($_POST['Order']))
		{
            $orderToProduct = $this->getOrderToProductToUpdate();
            $valid=true;
            foreach($orderToProduct as $item) {
                if ($item->status == Order::FINISH_STATUS) {
                    $item->scenario = 'deliveredStatus';
                } else {
                    $item->scenario = 'SaveTask';
                }
                $valid=$item->validate() && $valid;
            }
            if($valid) {
                foreach($orderToProduct as $item) {
                    $item->save();
                }                
                $this->redirect(array('update','id'=>$model->id));
            }

        } else {
            $orderToProduct = $model->orderedProductsDetails;
        }
        
        $writers_names = Writer::model()->findAllNames();
        $this->render('update',array(
			'model'=>$model,
            'orderToProduct'=>$orderToProduct,
            'writers_names'=>$writers_names,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $this->layout='//layouts/column3';
        
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];
        
		$this->render('admin',array(
			'model'=>$model,
		));
	}
    /**
     * 
     * @return array Product items
     */
    public function getOrderToProductToUpdate() {
        $items = array();

        if (isset($_POST['OrderToProduct']) && is_array($_POST['OrderToProduct'])) {
            foreach ($_POST['OrderToProduct'] as $id => $item) {
                $product = OrderToProduct::model()->findByPk($id);
                $product->attributes = $item;
                if (empty($item['writerName'])) $product->writer_id = 0;
                else $product->writerName = $item['writerName'];
                
                $items[] = $product;
            }
        }
        return $items;
    }
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Order the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
