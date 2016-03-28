<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_admin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
            'activateParents'=>true,
			'items'=>array(
				array('label'=>'Tasks List', 'url'=>array('/task/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Orders', 'url'=>array('/order/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='order'),
				array('label'=>'Sites', 'url'=>array('/product/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='product'),
				array('label'=>'Categories', 'url'=>array('/productCategory/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='productCategory'),
				array('label'=>'Writers', 'url'=>array('/writer/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='writer'),
				array('label'=>'Blog', 'url'=>array('/post/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='post'),
				array('label'=>'FAQ', 'url'=>array('/faq/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='faq'),
				array('label'=>'Subscribers', 'url'=>array('/subscriber/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='subscriber'),
				array('label'=>'Users', 'url'=>array('/user/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='user'),                
				array('label'=>'Pages Content', 'url'=>array('/pagesContent/admin'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='pagesContent'),
				array('label'=>'Settings', 'url'=>array('/settings/update'), 'visible'=>!Yii::app()->user->isGuest, 'active'=>$this->id=='settings'),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Exit', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'homeLink'=>false,
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
