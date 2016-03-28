<?php

class TaskController extends BackEndController
{
	public function actionIndex()
	{
		$ordered_products = new OrderToProduct;
//         Yii::app()->clientScript->scriptMap['*.js'] = false;
         
        if (!empty($_GET['task_date'])) {
            $date = CHtml::encode($_GET['task_date']);
        } else {
            $date = date('d/m/Y');
        }
        
		if(isset($_POST['OrderToProduct']))
		{
            $post_data = array_pop($_POST['OrderToProduct']);
            
            $model = OrderToProduct::model()->findByPk($post_data['id']);
			$model->attributes=$post_data;
            $model->writerName=$post_data['writerName'];
            
            $model->scenario = 'SaveTask';            
            $this->performAjaxValidation($model);            

			if ($model->save()) {
                $this->redirect(array('index','task_date'=>$date));
            }
            
		}
        
        $writers_names = Writer::model()->findAllNames();
        $activeList = $ordered_products->getForDate(OrderToProduct::dateReFormate($date));
        $statuses = Order::$statuses;
        unset($statuses[Order::FINISH_STATUS]);
		$this->render('index',array(
			'activeList'=>$activeList,
            'date'=>$date,
            'writers_names'=>$writers_names,
            'statuses'=>$statuses,
		));
	}

    public function actionUpdateStatusAjax()
    {
        $model = OrderToProduct::model()->findByPk($_GET['id']);
        $res = array('res' => 1);
        if(!empty($model) && !empty($_GET['status']))
		{
            $model->status = $_GET['status'];
            if (!$model->save()) {
                $res = array(
                    'res' => 0,
                    'messages' => $model->getErrors(),
                );                
            }
		} else {
            $res = array(
                'res' => 0,
                'messages' => array('No Task Data'),

            );
        }
        
        $res['data']=$model->attributes;
        echo json_encode($res);
        Yii::app()->end();
    }
    
    public function actionUpdateURLAjax()
    {
        if (isset($_POST['OrderToProduct']) && !empty($_POST['ajax']) && $_POST['ajax'] == 'deliverydialog-form') {
            $op = OrderToProduct::model()->findByPk($_POST['OrderToProduct']['id']);
            $op->scenario = 'deliveredStatus';
            $op->url_res = $_POST['OrderToProduct']['url_res'];
            if ($op->save()) {
                echo json_encode(array('data' => array('result' => 1)));
            } else {
                echo CActiveForm::validate($op, null, false);
            }
           
            Yii::app()->end();
        }
    }

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form-'.$model->id)
		{
            $model->validate();
            $result = array();
			foreach($model->getErrors() as $attribute=>$errors)
				$result[get_class($model).'_'.$model->id.'_'.$attribute]=$errors;
            
			echo json_encode($result);
			Yii::app()->end();
		}
	}    
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}