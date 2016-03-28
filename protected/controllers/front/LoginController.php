<?php
class LoginController extends Controller
{
    public $layout='//layouts/clear';
    public function actionForgot()
    {
		$model = new ForgotPasswordForm;
        $this->pageTitle = 'Forgot';
        
        if (!empty($_POST['ForgotPasswordForm'])) {
            $model->email = $_POST['ForgotPasswordForm']['email'];
            if ($model->validate()) {
                $forgot_link = $model->getLink();
                
                $html = $this->renderPartial('_forgot_email_html', array('url' => $forgot_link, 'user' => $model->profile), true);
                $text = $this->renderPartial('_forgot_email_text', array('url' => $forgot_link, 'user' => $model->profile), true);
                Yii::app()->mail->send($html, $text, 'Resetting your Netgeron Password', Yii::app()->params['emailNotif']['from_email'], $model->email);
                
                $this->redirect(array('Login/ForgotCompleted'));
            } else {
                sleep(5);
            }
        }
            
        $this->render('forgot', array('model'=>$model));
    }
    
    public function actionForgotCompleted()
    {
        $t = 'The email was sent to your email address - please check your incoming letters and follow the link.';
        $this->pageTitle = 'Forgot';
        
		$this->render('completed',array(
            't' => $t,
		));        
    }    
    
    public function actionReset()
    {
        $modelForgotPassword = new ForgotPasswordForm;
        $hash = !empty($_GET['h']) ? $_GET['h'] : '';
        $valid_hash = $modelForgotPassword->isHashValid($hash, empty($_GET['id'])?0:$_GET['id']);
        
        $user = null;
        if ($valid_hash) {
            $user = User::model()->findByPk($_GET['id']);
            if (!empty($user)) {
                Yii::import('application.extensions.securimage.Securimage');
                $img = new Securimage();
                if (isset($_POST['g-recaptcha-response']) 
                        && $img->check($_POST['g-recaptcha-response'])) {
                    $identity=new UserIdentityCustomer($user->email,'');
                    $modelForgotPassword->clearHash();

                    Yii::app()->user->login($identity, 0);
                    $this->redirect(array('myAccount/Settings'));                      
                } else {
                     $this->render('security',array(
                     ));
                     Yii::app()->end();
                }                
            }
        }
        
        $this->render('reset', array('user'=>$user));
    }
    
	public function actionIndex()
	{
		$model=new LoginFormCustomer;
		$model->scenario = 'std';
        $this->pageTitle = 'Login';
        
        if (!empty($_POST['fbtoken'])) {
            $model->scenario = 'fb';
            $info = Yii::app()->fbinterface->getInfo();
            if (empty($info['email'])) {
                $this->redirect(array('register/index', 'fbe' => 1));
            } elseif (!empty($info)) {
                if (empty($info['email'])) {
                    $this->redirect(array('register/index', 'fbe' => 1));
                }
                $userdb = User::model()->findByEmail($info['email']);
                if (empty($userdb)) {
                    $user = new User;
                    $user->addFB($info);
                    $this->redirect($this->createAbsoluteUrl('register/confirm', array('code'=>$user->getRegistrationConfirmationCode(), 'id'=>$user->id)));
                } else {
                    if (!$userdb->registration_confirmed) {
                        $this->redirect($this->createAbsoluteUrl('register/confirm', array('code'=>$userdb->getRegistrationConfirmationCode(), 'id'=>$userdb->id)));
                    }                    
                }
                $_POST['LoginFormCustomer']['username'] = $info['email'];
            }
        }
        // if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form-customer')
		{
            echo CActiveForm::validate($model);
            Yii::app()->end();                
		}

		//collect user input data
		if(isset($_POST['LoginFormCustomer']))
		{
			$model->attributes=$_POST['LoginFormCustomer'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
                Yii::app()->user->loginRedirect();
            }
		}

		// display the login form
		$this->render('index', array('model'=>$model));
	}    
}