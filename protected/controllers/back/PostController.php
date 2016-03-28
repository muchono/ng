<?php
class PostController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
    
    public function actionPreview($id)
    {
        $model=$this->loadModel($id);
		$this->renderPartial('_post_email',array(
			'model'=>$model,
            'email'=>'any',
    	));
    }
    
    public function createFrontUrl($params = '')
    {
        return Yii::app()->request->getBaseUrl(true).'/'.$params;
    }
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;
        $model_category=new PostCategory();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
            
            $model->image = CUploadedFile::getInstance($model,'image');
            $model->author_image = CUploadedFile::getInstance($model,'author_image');
            
			if($model->save()){
                if (!empty($model->image)) $model->saveImages($model->image->getTempName());
                if (!empty($model->author_image)) $model->author_image->saveAs($model::IMG_AUTHOR_DIR . $model->author_image->name);
                
                $model->addRelationRecords('categories', $model->categories);                
				
                $this->redirect(array('admin','id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'model_category'=>$model_category,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
            $_POST['Post']['image'] = $model->image;
            $_POST['Post']['author_image'] = $model->author_image;
            
			$model->attributes=$_POST['Post'];
            
            $author_image = CUploadedFile::getInstance($model,'author_image');
            $image = CUploadedFile::getInstance($model,'image');
            
            if (!empty($author_image)) $model->author_image = $author_image;
            if (!empty($image)) $model->image = $image;
            
            if (!empty($_POST['del_author_image_marker']) && $_POST['del_author_image_marker']) {
                $model->author_image = '';
            }
			if($model->save()){
                if (!empty($image)) $model->saveImages($model->image->getTempName());
                if (!empty($author_image)) $model->author_image->saveAs($model::IMG_AUTHOR_DIR . $model->author_image->name);
                
                $model->setRelationRecords('categories', $model->categories);
                
                if (!empty($_POST['send_but'])) {
                    $settings = Settings::model()->get();
                    
                    $emails = array();
                    foreach(Subscriber::model()->findAll() as $s){
                        $emails[] = $s->email;
                    }
                    foreach(User::model()->findAll('subscribe=1 AND active=1') as $s){
                        $emails[] = $s->email;
                    }
                    
                    $html = $this->renderPartial('_post_email', array('model'=>$model, 'email' => ''), true);
                    $emails = array_unique($emails);
                    foreach ($emails as $e) {
                        Yii::app()->mail->send($html, '', "Netgeron New Blog Post", Yii::app()->params['emailNotif']['from_email'], $e);
                    }
                    
                    $model->sent = 1;
                    $model->update();
                    
                    $this->redirect(array('post/update', 'id'=>$model->id, 's'=>1));
                    
                } else $this->redirect(array('admin'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Post');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
