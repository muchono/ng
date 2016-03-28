<?php
/* @var $this LoginController */

?>
		<div class="page sign-up login">
			<div class="sign-up-wrap">
				<div class="container">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'forgot-password-customer',
                        'enableAjaxValidation'=>true,
                    )); ?>                    
					<h1 class="text-center">Forgot password to Netgeron</h1>
					<div>
						<div class="input-line left-butt">
							<span><img src="img/content/email-ic.png" alt=""></span>
                            <?php echo $form->textField($model,'email', array('placeholder' => $model->getAttributeLabel('email'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'email'); ?></div>
					</div>
					<a href="" class="butt create">Restore Password</a>
                    <p class="text-1">Don't have an account? <a href="<?php echo $this->createUrl('register/')?>">Sign Up!</a></p>
                    <?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('forgot_password',"
        $('.butt.create').click(function(event){
            event.stopPropagation();
            $(this).parents('form:first').submit();
            return false;
        });
    ",CClientScript::POS_READY);?>