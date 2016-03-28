<?php

class RegisterController extends Controller
{
    public $layout='//layouts/clear';
    
    
    public function actionSend()
    {
        print 'HELLO';
        /*
        $model= User::model()->findByPk(102);
        $url = $this->createAbsoluteUrl('register/confirm', array('code'=>$model->getRegistrationConfirmationCode(), 'id'=>$model->id));
        $html = $this->renderPartial('_registration_email', array('url' => $url, 'user' => $model), true);
        $text = $this->renderPartial('_registration_email_text', array('url' => $url, 'user' => $model), true);
        */
        print 'HELLO';
        Yii::app()->mail->send('HTML', 'TESTX', 'Welcome to Netgeron - Email Verification', Yii::app()->params['emailNotif']['from_email'], 'mailmuchenik@gmail.com');
        print date('h:i:s');
        exit;
    }
    
	public function actionIndex()
	{
		$model=new User;
        $this->pageTitle = 'Registration Page';
        
        if (!empty($_POST['fbtoken'])) {
            $info = Yii::app()->fbinterface->getInfo();
            if (empty($info['email'])) {
                $this->redirect(array('register/index', 'fbe' => 1));
            } elseif (!empty($info)) {
                $userdb = User::model()->findByEmail($info['email']);
                if (empty($userdb)) {
                    $model->addFB($info);
                    $errors = $model->getErrors();
                    if (empty($errors)){
                        $this->redirect($this->createAbsoluteUrl('register/confirm', array('code'=>$model->getRegistrationConfirmationCode(), 'id'=>$model->id)));
                    }
                } else {
                    $model = $userdb;
                    if ($model->registration_confirmed) {
                        $model->addError('email', 'FB user is already registered');
                        $model->password = $model->password_confirm = '';
                    } else{
                        $this->redirect($this->createAbsoluteUrl('register/confirm', array('code'=>$model->getRegistrationConfirmationCode(), 'id'=>$model->id)));
                    }
                }
            }
        } else {
            $model->subscribe = 1;
        }
        
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                       
		if(empty($_POST['fbtoken']) && isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            if($model->save()){
                $url = $this->createAbsoluteUrl('register/confirm', array('code'=>$model->getRegistrationConfirmationCode(), 'id'=>$model->id));
                $html = $this->renderPartial('_registration_email', array('url' => $url, 'user' => $model), true);
                $text = $this->renderPartial('_registration_email_text', array('url' => $url, 'user' => $model), true);
                
                if (!$model->fb) {
                    Yii::app()->mail->send($html, $text, 'Welcome to Netgeron - Email Verification', Yii::app()->params['emailNotif']['from_email'], $model->email);
                }
                
                $this->redirect(array('register/completed', 'fb'=>$model->fb));                
            }
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}
    
    public function actionCompleted()
    {
        $this->pageTitle = 'Completed';
        if (!empty($_GET['fb']) && $_GET['fb']) $t = 'Registration completed.';
        else $t = 'The email was sent to your email address - please check your incoming letters and follow the link.';
		$this->render('completed',array(
            't' => $t,
		));        
    }
    
    public function actionSecureImage()
    {
        Yii::import('application.extensions.securimage.Securimage');
        $img = new Securimage();
        if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);
        $img->show(Yii::app()->getBasePath().'/extensions/securimage/backgrounds/bg4.jpg');
    }
    
	public function actionConfirm()
	{
        $res = 'Registration Confirmation Error';
        $this->pageTitle = 'Registration Confirmation';
        
        if (!empty($_GET['id'])){
            $model=User::model()->findByPk($_GET['id']);
            if (!empty($model) && $_GET['code'] == $model->getRegistrationConfirmationCode()) {
                if (!$model->registration_confirmed) {
                    Yii::import('application.extensions.securimage.Securimage');
                    $img = new Securimage();                    
                   if (isset($_POST['g-recaptcha-response']) 
                           && $img->check($_POST['g-recaptcha-response'])) {
                        $model->registration_confirmed=1;
                        $model->active=1;
                        $model->update();
                        $identity=new UserIdentityCustomer($model->email,'');
                        Yii::app()->user->login($identity, 0);
                        $this->redirect(array('buyPublication/'));                           
                   } else {
                        $this->render('security',array(
                            'res'=>$res,
                        ));
                        Yii::app()->end();
                   }
                }
            }
        }
		$this->render('registration_confirmed',array(
			'res'=>$res,
		));        
    }
    
	/**
	 * Performs the AJAX validation.
	 * @param FaqCategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	} 
}