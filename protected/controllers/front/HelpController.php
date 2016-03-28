<?php

class HelpController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
                'expression'=>'Yii::app()->user->profile->id != 0',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionIndex()
	{
        $this->page = 'help';
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'popular_question = 1';
        $criteria->order = 'id Desc';
        
        $faq = Faq::model()->findAll($criteria);
		$this->render('index', array('faq' => $faq));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}