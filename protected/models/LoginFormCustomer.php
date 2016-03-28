<?php

class LoginFormCustomer extends CFormModel
{
	public $username;
	public $password;
    public $fbtoken;
	public $rememberMe;
    
	private $_identity;

	public function rules()
	{
		return array(
			array('rememberMe', 'safe'),
			array('username', 'email', 'message'=>'Please enter an {attribute}.'),
			array('username', 'required', 'message'=>'Please enter an {attribute}.'),
            array('username','exist', 'attributeName' => 'email', 'className' => 'User', 'message'=>'User not found. Please register.'),            
			
            array('fbtoken', 'authenticateFB', 'message'=>'User not found. Please register.', 'on'=>'fb', 'skipOnError' => true),
            
			array('password', 'required', 'message'=>'Please enter a {attribute}.', 'on'=>'std'),
			array('password', 'authenticate', 'on'=>'std', 'skipOnError' => true),
		);
	}
    
    
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		$this->_identity=new UserIdentityCustomer($this->username,$this->password);
		if(!$this->_identity->authenticate()){
            $this->addError('password', $this->_identity->errorMessage);
        }
	}
    
	/**
	 * Authenticates the password for Facebook scenario.
	 * This is the 'authenticateFB' validator as declared in rules().
	 */
	public function authenticateFB($attribute,$params)
	{
		$this->_identity=new UserIdentityCustomer($this->username,'');
		if(!$this->_identity->authenticateFB()){
            $this->addError('username', $this->_identity->errorMessage);
        }
	}
    
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me',
			'username' => 'E-mail Address',
			'password' => 'Password',

		);
	}

	/**
	 * Logs in the user using the given password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentityCustomer($this->username,$this->password);
            if ($this->scenario == 'fb') $this->_identity->authenticateFB();
            else $this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentityCustomer::ERROR_NONE)
		{
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}
		else
			return false;
	}
}
