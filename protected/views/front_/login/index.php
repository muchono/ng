<?php
/* @var $this LoginController */

?>
		<div class="page sign-up login">
			<div class="sign-up-wrap">
				<div class="container">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form-customer',
                    )); ?>                
					<h1 class="text-center">Login to Netgeron</h1>
					<a class="sign-up-facebook" href="#">
						<img src="img/content/login-facebook.png" alt="">
					</a>
                    <div class="error-message"><?php echo $form->error($model,'fbtoken'); ?></div>
					<div class="title-h2">
						<h2>Or</h2>
					</div>
					<div>
						<div class="input-line left-butt <?php echo ($model->hasErrors('username') ? 'error' : ''); ?>">
							<span><img src="img/content/email-ic.png" alt=""></span>
                            <?php echo $form->textField($model,'username', array('placeholder' => $model->getAttributeLabel('username'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'username'); ?></div>
						<div class="input-line left-butt <?php echo ($model->hasErrors('password') ? 'error' : ''); ?>">
							<span><img src="img/content/pass-ic.png" alt=""></span>
                            <?php echo $form->passwordField($model,'password', array('placeholder' => $model->getAttributeLabel('password'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'password'); ?></div>
						<div class="remember text-center">
                            <?php echo $form->checkBox($model,'rememberMe'); ?>
							<label for="remember_me"><?php echo $model->getAttributeLabel('rememberMe')?></label>
						</div>
					</div>
					<a href="" class="butt create">Login</a>
                    <p class="text-2"><a href="<?php echo $this->createUrl('login/forgot'); ?>">Forgot Account Details?</a></p>
                    <p class="text-1">Don't have an account? <a href="<?php echo $this->createUrl('register/'); ?>">Sign Up!</a></p>
                    <?php echo CHtml::hiddenField('fbtoken', '', array('id'=>'fbtoken'))?>
                    <?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('login',"
        function FBLoginCallback(res) {
            if (res) {
                $('#fbtoken').val('".md5(time())."');
                $('.butt').click();
            }
        }
        $('.sign-up-facebook').click(function(event){
            event.stopPropagation();
            FBLogin();
            return false;
        });
        
        $('.butt').click(function(event){
            event.stopPropagation();
            $(this).parents('form:first').submit();
            return false;
        });
        ".Yii::app()->fbinterface->getJS('FBLoginCallback')."
 
    ",CClientScript::POS_READY);?>