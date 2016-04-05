<?php
Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.Zend'));
Yii::setPathOfAlias('SEOstats',Yii::getPathOfAlias('application.extensions.SEOstats'));

class FrontController extends Controller
{
    public function actionGetStats()
    {
        Yii::import('application.extensions.SEOstats.Services.3rdparty.GTB_PageRank', true);
        $url = 'http://www.nahklick.de/';
        $seostats = new \SEOstats\SEOstats;
        $seostats->setUrl($url);
        $pagerank = \SEOstats\Services\Google::getPageRank();
        
        echo "The current Google PageRank for {$url} is {$pagerank}." . PHP_EOL;
        echo 'Alexa Rank: '. \SEOstats\Services\Alexa::getGlobalRank() . PHP_EOL;
        echo 'DA: '. \SEOstats\Services\Mozscape::getPageAuthority()/100 . PHP_EOL;
        exit;
    }
    
    public function actionUnsubscribe()
	{
        $model = new UnsubscribeForm;
        $this->layout='//layouts/clear';
        if (!empty($_POST['UnsubscribeForm'])){
            $model->email = $_POST['UnsubscribeForm']['email'];
            if ($model->validate()) {
                $model->unsubscribe();
                $this->redirect(array('front/unsubscribe', 's'=>1));
            }
        }
        $this->render('unsubscribe', array('model'=>$model));
    }
    
	public function actionHideContent()
	{
        if (!empty($_GET['href'])) {
            $toHide = new PagesContentHide;
            $toHide->user_id = Yii::app()->user->profile->id;
            $toHide->href = $_GET['href'];
            $toHide->hide();
        }
        Yii::app()->end();
	}
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('');
    }
    
    public function actionGetCartInfo()
    {
        $r = $this->getCartInfo();
        
        echo json_encode($r);
        Yii::app()->end();
    }
    
	public function actionIndex()
	{
        $this->page='home';
        $this->add_footer_text = 1;
        $this->pageTitle = 'Manual Link Building Services - Sponsored Posts on the World Popular Websites';
        
        $this->render('index');
	}
    
    public function actionTerms()
    {
        $this->page='terms_of_use';
        
        $this->render('terms');        
    }
    
    public function actionPrivacy()
    {
        $this->page='terms_of_use';
        
        $this->render('privacy');        
    }
    
	public function actionHowItWorks()
	{
        $this->page='hit';
        $this->pageTitle = 'How it works';
        
        $this->render('howitworks');
	}
    
	public function actionAbout()
	{
        $this->page='about';
        $this->pageTitle = 'About Netgeron';
        
        $this->render('about');
	}
    
	public function actionForWriters()
	{
        $this->page='for_writers';
        $this->pageTitle = 'Job for writers online';
        
        $this->render('forwriters');
	}
    
	public function actionContact()
	{
        
        $model = new ContactForm;
        $this->page='contacts';
        $this->pageTitle = 'Contact Form';
        
		$this->performAjaxValidation($model);
       
		if(isset($_POST['ContactForm']))
		{
            $_POST['ContactForm']['verifyCode'] = $_POST['g-recaptcha-response'];
			$model->attributes=$_POST['ContactForm'];
            if($model->validate()){
                sleep(2);
                $message = new Zend\Mail\Message();
                $settings = Settings::model()->get();
                $html = $this->renderPartial('_contact_email', array('model' => $model), true);
                
                $message->addFrom($model->email, "Netgeron Contact Form")
                        ->addTo($settings->email)
                        ->setSubject("NetGeron.com Contact Form");
                
                $bodyPart = new Zend\Mime\Message();

                $bodyMessage = new Zend\Mime\Part($html);
                $bodyMessage->type = 'text/html';

                $bodyPart->setParts(array($bodyMessage));
                $message->setBody($bodyPart);
                
                $transport = new Zend\Mail\Transport\Sendmail();
                
                 $transport->send($message);
                
                $this->redirect(array('front/contact', 'sent'=>'1'));
            }
		} else if (!Yii::app()->user->isGuest) {
            $model->email = Yii::app()->user->profile->email;
            $model->name = Yii::app()->user->profile->name;
        }
        
        $this->render('contact', array('model'=>$model));
	}
    
	public function actionContent()
	{
        $page_name = 'index';
        if (!empty($_GET['id'])) {
            $page_name = $_GET['id'];
        }
        $model = new PagesContent;
        
        $pc = $model->find(array(
                    'select'=>'name,content,href,submenu',
                    'condition'=>'href=:hrefID',
                    'params'=>array(':hrefID'=>$page_name),
                    ));
        if (empty($pc)) {
            $this->redirect($this->createUrl('front/content'));
        }
        
		$this->render('content', array('pc' => $pc));
	}
    
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else {
                
                $pc = PagesContent::model()->find(array(
                        'select'=>'name,content,href',
                        'condition'=>'href=:hrefID',
                        'params'=>array(':hrefID'=>'error'),
                        ));
                $pc->content = str_replace('%%ERROR%%', $error['message'], $pc->content);
                $this->render('content', array('pc' => $pc));
            }
		}
	}    
    
	public function actionNews()
	{
		$model = new News;
        $news = $model->active()->findAll();
        
        $this->render('news', array('news' => $news, 'model' => $model));
	}
    
    public function actionSearch()
    {
        $results = array();
        if (!empty($_GET['s'])) {
            $model = new PagesContent;
            $results = $model->searchByStr($_GET['s']);
        }
        
        $this->render('search', array('results' => $results, 'search' => $_GET['s']));
    }
	
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contact-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}  
    
}