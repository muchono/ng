<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
		<div class="page sign-up">
			<div class="sign-up-wrap">
				<div class="container">
                    
					<h1 class="text-center">Create your <br>Netgeron Account</h1>
					<?php if (!empty($_GET['fbe'])){?>
                    <div class="fberror">
                        In your Facebook account settings there was enabled an option that do not allow to transfer data to other websites so please register via your email address.
                    </div>
                    <?php } else {?>
                    <a class="sign-up-facebook" href="#">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/sign-up-facebook.png" alt="">
					</a>
                    <?php }?>
					<div class="title-h2">
						<h2>Or</h2>
					</div>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'user-register-form',
                    )); ?>
					<div>
                        <div class="input-line left-butt <?php echo ($model->hasErrors('email') ? 'error' : ''); ?>">
							<span><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/email-ic.png" alt=""></span>
                            <?php echo $form->textField($model,'email', array('placeholder' => $model->getAttributeLabel('email'))); ?>
						</div>
						<div class="error-message"><?php echo $form->error($model,'email'); ?></div>
						<div class="input-line left-butt <?php echo ($model->hasErrors('name') ? 'error' : ''); ?>">
							<span><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/user-ic.png" alt=""></span>
							<?php echo $form->textField($model,'name', array('placeholder' => $model->getAttributeLabel('name'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'name'); ?></div>
						<div class="input-line left-butt <?php echo ($model->hasErrors('password') ? 'error' : ''); ?>">
							<span><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/pass-ic.png" alt=""></span>
							<?php echo $form->passwordField($model,'password', array('placeholder' => $model->getAttributeLabel('password'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'password_confirm'); ?></div>
						<div class="input-line left-butt <?php echo ($model->hasErrors('email') ? 'error' : ''); ?>">
							<span><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/pass-ic.png" alt=""></span>
							<?php echo $form->passwordField($model,'password_confirm', array('placeholder' => $model->getAttributeLabel('password_confirm'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'password_confirm'); ?></div>
						
                        <div class="input-line left-butt <?php echo ($model->hasErrors('email') ? 'error' : ''); ?>">
                        <p class="text-1"><?php echo $form->checkbox($model, 'subscribe')?> - Subscribe to Newsletters</p>
						</div>                        
					</div>
					<a href="submit" class="butt create">Create Account</a>
                    <?php echo CHtml::hiddenField('fbtoken', '', array('id'=>'fbtoken'))?>
                    <?php $this->endWidget(); ?>
					<p class="text-1">By registering you confirm that you accept the <a href="<?php echo $this->createUrl('/terms'); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo $this->createUrl('/privacy'); ?>" target="_blank">Privacy Policy</a></p>
					<p class="text-2">Already have an account? <a href="<?php echo $this->createUrl('login/'); ?>">Sign In</a></p>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('register_fb',"
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