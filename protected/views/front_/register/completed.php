<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
		<div class="page sign-up">
			<div class="sign-up-wrap">
				<div class="container">
                    
                    <h1 class="text-center"><?php echo $t; ?></h1>
					<p class="text-2"><a href="<?php echo $this->createUrl('login/'); ?>">Sign In</a></p>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('register_completed',"
            setInterval(replaceToLogin, 2500);
    function replaceToLogin(){
        location.replace('".$this->createUrl('login/')."');
    }
    ",CClientScript::POS_READY);?>