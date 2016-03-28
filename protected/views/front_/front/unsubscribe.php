<?php
/* @var $this LoginController */

?>
		<div class="page sign-up login">
			<div class="sign-up-wrap">
				<div class="container">
                    <?php if (empty($_GET['s'])) {?>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'forgot-password-customer',
                        'enableAjaxValidation'=>true,
                    )); ?>                    
					<h1 class="text-center">Unsubscribe Email</h1>
					<div>
						<div class="input-line left-butt">
							<span><img src="img/content/email-ic.png" alt=""></span>
                            <?php echo $form->textField($model,'email', array('placeholder' => $model->getAttributeLabel('email'))); ?>
						</div>
                        <div class="error-message"><?php echo $form->error($model,'email'); ?></div>
					</div>
                    <a href="" class="butt create">Unsubscribe</a>
                    <?php $this->endWidget(); ?>
                    <?php } else {?>
					<h1 class="text-center">Unsubscribed Successfully</h1>
                    <?php }?>
				</div>
			</div>
		</div>
    <?php Yii::app()->clientScript->registerScript('unsubscribe_script',"
        $('.butt.create').click(function(event){
            event.stopPropagation();
            $(this).parents('form:first').submit();
            return false;
        });
    ",CClientScript::POS_READY);?>