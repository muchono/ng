<?php

class FaqController extends Controller
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
        $this->page = 'blog faq';
        
        $criteria = new CDbCriteria();
        if (!empty($_GET['search'])) {
            $criteria->condition = 'title LIKE :s';
            $criteria->params[':s'] = '%'.$_GET['search'].'%';
        }
        if (!empty($_GET['cid'])) {
            $criteria->with = array( 
                'faq_to_category' => array(
                    'select' =>false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'category_id = :cid',
                    'params'=> array(':cid' => $_GET['cid']),
                )
            ); 
            $criteria->together = true; 
        }        
        $criteria->order = '`order`, title';
        
        $count=Faq::model()->count($criteria);
        
        $pager=new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);

        $faq = Faq::model()->findAll($criteria);

		$this->render('index', array(
            'faq' => $faq,
            'pager'=>$pager,
        ));
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