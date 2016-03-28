<?php
class BackEndController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
 
    final public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
                'actions'=>array('login'),
            ),
            array('allow',
                'users'=>array('@'),
                'expression'=>'Yii::app()->user->getId() == "admin"',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
}