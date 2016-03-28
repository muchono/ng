<?php

class MyAccountController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
                'expression'=>'Yii::app()->user->profile->id != 0',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionMyNetgeron()
	{
        $this->page = 'my';
        
        $orders = Order::model()->findAll('user_id='.Yii::app()->user->profile->id);
        $opcount = 0;
        foreach($orders as $o){
            $opcount += $o->products_count;
        }
		$this->render('MyNetgeron', array(
            'orders'=>$orders,
            'opcount'=>$opcount,
        ));
	}

	public function actionSettings()
	{
        $this->page = 'settings';
        $user = Yii::app()->user->profile;
        $user_billing = $user->billing;
        
        if (empty($user_billing)) {
            $user_billing = new UserBilling;
            $user_billing->user_id = $user->id;
            $user_billing->agreed = 1;
            $user_billing->payment = 'PayPal';
        }
        
        if (!empty($_POST)) {
            $user->attributes = $_POST['User'];

            $user_billing->attributes = $_POST['UserBilling'];
            $user->scenario = 'settings';
            $valid = $user->validate();
            $valid = $user_billing->validate() && $valid;
            if ($valid) {
                $user->save();
                Yii::app()->user->setId($user->email);
                $user_billing->save();
            }
        }
        $user->password = '';
        $user->password_confirm = '';
		$this->render('Settings', 
                array(
                    'user_billing' => $user_billing,
                    'user' => $user,
                ));
	}
    
    public function actionSignOut()
	{
        Yii::app()->user->logout();
        $this->redirect(array('front/'));
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