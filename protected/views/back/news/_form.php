<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date_added'); ?>
        <?php
        $this->widget('CMaskedTextField', array(
        'model' => $model,
        'attribute' => 'date_added',
        'mask' => '99-99-9999 99:99',
        'htmlOptions' => array('size' => 14)
        ));
        ?>		
		<?php echo $form->error($model,'date_added'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model_category,'title'); ?>
		<?php echo $form->listBox($model_category,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>    
    
    
	<div class="row">
		<?php echo $form->labelEx($model,'img'); ?>
        <?php if (!$model->isNewRecord && $model->img){?>
            <?php echo CHtml::image($model::IMG_DIR . $model->img, '', array('id' => 'preview_img', 'width' => 210, 'height' => 150)); ?> 
            <span id="del_image" style="cursor: pointer">[X]</span>
        
            <?php echo CHtml::hiddenField('del_image_marker', 0); ?>
        <br/><br/>
            
        <?php }?>
		<?php echo $form->fileField($model,'img'); ?>
		<?php echo $form->error($model,'img'); ?>
	</div>

    <div class="tinymce">
    <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
        'model' => $model,
        'attribute' => 'content',
        'editorTemplate' => 'full',
        'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce'),
        )); ?>
    </div>
    <br/>
	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model,'active', array(1 => 'да', 0 => 'нет')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
    Yii::app()->clientScript->registerScript('imgdel_script',"
    $('#del_image').click(function(){
        $('#preview_img').hide();
        $('#del_image').hide();    
        $('#del_image_marker').val(1);
    });
    ",CClientScript::POS_READY);
?>