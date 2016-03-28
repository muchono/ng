<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $page = '';
    public $add_footer_text = 0;
    
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    public function getFooterDescText()
    {
        return PagesContent::model()->getContent('footer-description');
    }

    public function actionFooterDescText()
    {
        echo $this->getFooterDescText();
    }
    
    public function getCartInfo()
    {
        $r = array('count' => 0);
        if (!Yii::app()->user->isGuest) {
            $info = Cart::getByUser(Yii::app()->user->profile->id);
            $r = array(
                'count' => $info['count'],
                'total' => $info['total'],
                'text' => $info['count'] ?  $info['count'] .' site'.($info['count'] > 1 ? 's' : '').' - $'.$info['total'] : 'Cart is Empty',
            );
        }
        return (object) $r;
    }
    
   
    public function showSubscribe()
    {
        $r = isset(Yii::app()->session['subscribed']) && Yii::app()->session['subscribed'] ? false : true;
        if (!Yii::app()->user->isGuest 
                && isset(Yii::app()->user->profile) && Yii::app()->user->profile->subscribe) {
            $r = false;
        }
        return $r;
    }
}