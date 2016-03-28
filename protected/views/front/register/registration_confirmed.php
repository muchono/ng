<?php
/* @var $this RegisterController */

?>
		<div class="page sign-up login">
			<div class="sign-up-wrap">
				<div class="container">
                    <h1 class="text-center"><?php echo $res; ?></h1>
                    <p class="text-2"><a href="<?php echo $this->createUrl('login/')?>">LOGIN</a></p>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('register_fb',"
    setInterval(replaceToLogin, 4000);
    function replaceToLogin(){
        location.replace('".$this->createUrl('login/')."');
    }
    ",CClientScript::POS_READY);?>
