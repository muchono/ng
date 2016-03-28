<?php

/*
 * Customer Web User
 */
class CustomerWebUser extends CWebUser{

    const ROLE = 'customer';
    
    public $guestName='Customer';
    private $_profile = null;
    public $loginUrl=array('/login/');


    public function init()
    {
       parent::init();
       if(!$this->getIsGuest()){
            $this->setProfile();
       }
    }
    
    public function loginRedirect()
    {
        $url = array('buyPublication/ChooseResource');
        if (!empty(Yii::app()->session['login_redirect'])){
            $url = Yii::app()->session['login_redirect'];
            Yii::app()->session['login_redirect'] = '';
        }
        Yii::app()->getController()->redirect($url);
    }
    
    public function loginRequired()
	{
        Yii::app()->session['login_redirect'] = Yii::app()->request->url;

        parent::loginRequired();
    }
    
    public function setProfile()
    {
        $this->_profile = User::model()->findByEmail($this->getId());
    }
    
    public function getProfile()
    {
       return $this->_profile;
    }
    
    public function isCHidden($href)
    {
        $r = true;
        if (!empty($this->_profile)) {
            $pch = new PagesContentHide;
            $pch->user_id = $this->_profile['id'];
            $pch->href = $href;
            $r = $pch->isHidden();
        }
        return $r;
    }
    
    public function getIsGuest()
    {
        return !$this->isCustomer() || parent::getIsGuest();
    }
    
    protected function isCustomer()
    {
        return 1;
    }
}