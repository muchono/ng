<?php

class BlogController extends Controller
{
    public $page = 'blog';
	public function actionIndex()
	{
        $post = new Post;
        $this->pageTitle = 'SEO Blog - Netgeron';
        $posts = $post->findByFilter($_GET, $pager);
        $this->render('index', array('posts'=>$posts, 'pager'=>$pager));
	}
    
    public function actionRSS()
    {
        $posts = Post::model()->getRss();
        echo $this->renderPartial('rss', array('posts'=>$posts));
    }
    
	public function actionPost()
	{
        $this->page = 'blog post';
        $post = null;
        if (!empty($_GET['href'])) {
            $post = Post::model()->findByHref($_GET['href'], (empty($_GET['all']) ? array(): array('all' => 1)));
        }
        
        if (!$post) {
            $this->redirect($this->createUrl('blog/'));
        }
        
        $this->pageTitle = $post->title;
        Yii::app()->clientScript->registerMetaTag($post->meta_description, 'description');
        Yii::app()->clientScript->registerMetaTag($post->meta_keywords, 'keywords');
        
        $post->views += 1;
        $post->update();
        
        $this->render('post', array('post'=>$post));
	}
    
    public function actionSubscribe()
    {
        $subscriber = new Subscriber;
        $subscriber->email = !empty($_POST['email']) ? $_POST['email'] : '';
        if ($subscriber->save()) {
            Yii::app()->session['subscribed'] = true;
        }
        
        $r = array('errors'=>join(' ', $subscriber->getErrors('email')));
        
        echo json_encode($r);
        Yii::app()->end();
    }
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cart the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cart::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}