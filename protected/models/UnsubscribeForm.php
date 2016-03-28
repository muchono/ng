<?php

class UnsubscribeForm extends CFormModel
{
    public $email = '';
    public $subscribed_in = array();
    
    public function rules()
	{
		return array(
			array('email', 'email', 'message'=>'Please enter an {attribute}.'),
			array('email', 'required', 'message'=>'Please enter an {attribute}.'),
            array('email', 'userExists'),
		);
	}
    
    public function userExists()
    {   $s = Subscriber::model()->find('email=:email', array(':email'=>$this->email));
        $u = User::model()->find('email=:email', array(':email'=>$this->email));
		if(empty($u) && empty($s)){
            $this->addError('email', 'User is not subscribed.');
        } else {
            if (!empty($s)) $this->subscribed_in[] = $s;
            if (!empty($u)) $this->subscribed_in[] = $u;
        }
    }
    
    public function unsubscribe()
    {
        foreach($this->subscribed_in as $o) {
            $type = get_class($o);
            switch ($type) {
                case 'User':
                    $o->subscribe = 0;
                    $o->update();
                    break;
                case 'Subscriber': 
                    $o->delete();
                    break;
            }
        }
    }
    
        /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
		);
	}
    
}
