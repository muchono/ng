<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textArea($model,'title',array('size'=>100,'maxlength'=>255, 'cols'=>60)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'categories'); ?>
		<?php echo $form->dropDownList($model, 'categories', CHtml::listData(FaqCategory::model()->sort_asc()->findAll(), 'id', 'title'), array('multiple'=>'multiple', 'size'=>10, 'style' => 'width: 400px')); ?>
		<?php echo $form->error($model,'categories'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'popular_question'); ?>
		<?php echo $form->checkBox($model,'popular_question', array()); ?>
		<?php echo $form->error($model,'popular_question'); ?>
	</div>    
    <br/>
	<div class="row">
        <?php echo $form->labelEx($model,'answer'); ?>        
        <div class="tinymce">
            <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
                'model' => $model,
                'attribute' => 'answer',
                'editorTemplate' => 'full',
                'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce'),
                )); ?>
        </div>
        <br/>
		<?php echo $form->error($model,'answer'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->