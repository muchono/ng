<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
        <?php if(!$model->isNewRecord){?>
    <div class="view">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'orders_num',
            'websites_num',
        ),
    )); ?>    
    </div>
    <?php }?>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'password_confirm'); ?>
		<?php echo $form->passwordField($model,'password_confirm',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password_confirm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subscribe'); ?>
        <?php echo $form->dropDownList($model,'subscribe', array(1 => 'yes', 0 => 'no')); ?>
		<?php echo $form->error($model,'subscribe'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
        <?php echo $form->dropDownList($model,'active', array(1 => 'yes', 0 => 'no')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>
    <?php if ($model->isNewRecord){?>
    <?php echo $form->hiddenField($model,'registration_confirmed'); ?>
    <?php }?>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->