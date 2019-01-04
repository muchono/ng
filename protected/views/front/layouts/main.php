<?php /* @var $this Controller */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="webmoney" content="23397721-CB21-4704-9DA9-3DB8E7F2F731"/>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/chosen.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
             <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.png" type="image/x-icon" />
             <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.png" type="image/x-icon">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
	<div class="page-wrap">
        <div class="page <?php echo $this->page;?>">
        <?php echo $this->renderPartial('//layouts/header'); ?>
			<section class="content">
				<?php echo $content; ?>
			</section>
        <?php echo $this->renderPartial('//layouts/footer'); ?>
		</div>
	</div>
	<!--[if lt IE 9]> 
		<script src="js/html5shiv.js"></script>
	<![endif]-->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/icheck.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen.jquery.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
    <?php if (!Yii::app()->user->isGuest){?>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/cart.js"></script>
    <?php }?>
</body>
</html>