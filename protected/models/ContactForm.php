<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $message;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, message', 'required'),
			array('name, message', 'length', 'max'=>1000),
			array('message,name', 'filter', 'filter' => array('CHtml', 'encode')),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'verifyCodeValidator'),
		);
	}
    
    public function verifyCodeValidator($attribute,$params)
    {
        $r = false;
        if (!empty($this->verifyCode)){
            $json = Yii::app()->curl->post('https://www.google.com/recaptcha/api/siteverify',array(
            'secret' => '6LfMmQMTAAAAAKyOk7yKqFgYl9jqRQGosD1jz_l-',
            'response' => $this->verifyCode,
            ));

            $r = json_decode($json)->success;
        }
        
        if (!$r){
            $this->addError($attribute, 'Spam verification error');
        }
    }
    
    public function getSubjectList()
    {
        return array(
            1=>'Questions about the service',
            2=>'Technical problems',
            3=>'I can write posts on trusted sites',
            4=>'Other',
        );
    }
    
    public function getSubjectName()
    {
        $list = $this->getSubjectList();
        return $list[$this->subject];
    }

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>'Name',
			'email'=>'Email',
			'subject'=>'Subject',
			'message'=>'Message',
			'verifyCode'=>'Verification Code',
		);
	}
}