<?php

class ForgotPasswordForm extends CFormModel
{
	const HASH_TOKEN = 'fk!(cfksd3NCskf23XXS#dsacx';
    public $email = '';
    public $profile = null;
            
    public function rules()
	{
		return array(
			array('email', 'email', 'message'=>'Please enter an {attribute}.'),
			array('email', 'required', 'message'=>'Please enter an {attribute}.'),
            array('email', 'exist', 'attributeName' => 'email', 'className' => 'User', 'message'=>'User not found.'),
            array('email', 'activeUser'),
		);
	}
    
    public function activeUser()
    {
		$user = User::model()->findByEmail($this->email);
		if(!empty($user) && !$user->active){
            $this->addError('email', 'User is not active in the system.');
        }
    }
    
    public function afterValidate()
    {
        $errors = $this->getErrors();
        if (empty($errors)) {
            $this->profile = User::model()->findByEmail($this->email);
            $hash = $this->generateHash($this->profile->id);
            $this->saveHash($hash);
        }
        parent::afterValidate();
    }

    public function getLink()
    {
        return Yii::app()->createAbsoluteUrl('login/reset', array('h'=>$this->getHash(), 'id'=>$this->profile->id));
    }
    
    public function saveHash($hash)
    {
        Yii::app()->session['forgot_hash'] = $hash;
    }
    
    public function generateHash($id)
    {
        return md5(date('dmy').self::HASH_TOKEN.$id);
    }
    
    public function isHashValid($hash, $id)
    {
        return ($hash == $this->generateHash($id) 
                && $hash == $this->getHash()) ? 1 : 0;
    }
    
    public function getHash()
    {
        return !empty(Yii::app()->session['forgot_hash']) ? Yii::app()->session['forgot_hash'] : '';
    }
    
    public function clearHash()
    {
        Yii::app()->session['forgot_hash'] = '';
    }
    
        /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
			'password' => 'Password',

		);
	}
    
}
