<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentityCustomer extends CUserIdentity
{
    const SALT = 'dD4_gds';
    const ERROR_USER_DISABLED=3;
    const ERROR_REGISTRATION_UNVERIFIED=4;
    const ERROR_FB_USER=5;
    
    public function isExist()
    {
        $user = User::model()->findByEmail($this->username);
        return !empty($user);
    }
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $user = User::model()->findByEmail($this->username);
        
    	if(empty($user->attributes))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($user->fb)
			$this->errorCode=self::ERROR_FB_USER; 
		elseif(!$this->isPWDHash($this->password, $user->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		elseif(!$user->registration_confirmed)
			$this->errorCode=self::ERROR_REGISTRATION_UNVERIFIED;
		elseif(!$user->active)
			$this->errorCode=self::ERROR_USER_DISABLED;
		else {
			$this->errorCode=self::ERROR_NONE;
        }
        
        $this->errorMessage = $this->getErrorByCode($this->errorCode);
		return !$this->errorCode;
	}
    
    public function authenticateFB()
	{
        $user = User::model()->findByEmail($this->username);
    	if(empty($user))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(!$user->active)
			$this->errorCode=self::ERROR_USER_DISABLED;
		else {
			$this->errorCode=self::ERROR_NONE;
        }
        
        $this->errorMessage = $this->getErrorByCode($this->errorCode);
		return !$this->errorCode;
	}
    
    static public function getErrorByCode($e)
    {
        $errors = array(
            1 => 'E-mail not found',
            2 => 'Password incorrect',
            3 => 'Account disabled',
            4 => 'E-mail verification pending',
            5 => 'Please use Facebook login',
        );
        
        return isset($errors[$e]) ? $errors[$e] : '';
    }
    
    
    static public function getPWDHash($str)
    {
        //Yii::app()->securityManager->encrypt($str);
        return crypt($str, static::SALT);
    }
    
    public function isPWDHash($str, $hash)
    {
        return static::getPWDHash($str) == $hash;
    }
}