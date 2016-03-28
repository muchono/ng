<?php
Yii::setPathOfAlias('Facebook',Yii::getPathOfAlias('application.vendors.Facebook'));
/**
 * FB Interface
 * Debugger: https://developers.facebook.com/tools/debug/
 */
class FBInterface extends CComponent
{
    public $appID = '';
    public $appSecret = '';
    public $scope = 'email,public_profile';

    public function init()
    {

    }
    
    public function startSession()
    {
        Facebook\FacebookSession::setDefaultApplication($this->appID, $this->appSecret);
    }
    
    /**
     * @return array
     */
    public function getInfo()
    {
        $info = array();
        
        $this->startSession();
        $helper = new Facebook\FacebookJavaScriptLoginHelper();
        try {
            $session = $helper->getSession();
        } catch(Facebook\FacebookRequestException $ex) {
            // When Facebook returns an error
        } catch(\Exception $ex) {
            // When validation fails or other local issues
        }
        //name,email
        if ($session) {
            $me = (new Facebook\FacebookRequest(
            $session, 'GET', '/me'/*/accounts?fields='.$this->scope*/
            ))->execute()->getGraphObject(Facebook\GraphUser::className());
            if ($me) {
                $info['name'] = $me->getName();
                $info['email'] = $me->getEmail();
            }
        }
        return $info;
    }
    
    public function getJS($callBack)
    {
        return "
        function FBLogin() {
            FB.getLoginStatus(function(response) {
                if (response.status !== 'connected') {
                    FB.login(function(response){
                        var res = 0;
                        if (response.status === 'connected') {
                            res = 1;
                        }
                        ".$callBack."(res);
                    }, {scope: '".$this->scope."'});                    
                }else{
                    ".$callBack."(1);
                }
                
            })
        }
        
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = '//connect.facebook.net/en_US/sdk.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        
        window.fbAsyncInit = function() {
        FB.init({
          appId      : '".$this->appID."',
          cookie     : true,
          xfbml      : true,
          version    : 'v2.1'
        });
        }            
        ";
    }
}