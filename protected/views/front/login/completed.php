<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
		<div class="page sign-up">
			<div class="sign-up-wrap">
				<div>
                    <center>
                    <h1 class="text-center" style="width:900px"><?php echo $t; ?></h1>
					<p class="text-2"><a href="<?php echo $this->createUrl('login/'); ?>">Sign In</a></p>
                    </center>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('register_completed',"
            setInterval(replaceToLogin, 6000);
    function replaceToLogin(){
        location.replace('".$this->createUrl('login/')."');
    }
    ",CClientScript::POS_READY);?>