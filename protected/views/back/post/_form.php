<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),    
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>110,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'meta_description'); ?>
		<?php echo $form->textField($model,'meta_description',array('size'=>110,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_description'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>110,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'url_anckor'); ?>
		<?php echo $form->textField($model,'url_anckor',array('size'=>110,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'url_anckor'); ?>
	</div>    
	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
        <?php echo $form->dropDownList($model,'active', array(1 => 'yes', 0 => 'no')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'image').$form->fileField($model,'image'); ?>
        <?php if (!$model->isNewRecord && $model->image){?>
            <?php echo '<br/>' . CHtml::image($model->getImageName('thumb'), '', array('id' => 'preview_img')); ?>
        <br/><br/>
            
        <?php }?>
		<?php echo $form->error($model,'image'); ?>
	</div> 
    <div class="row">
        <?php echo $form->labelEx($model,'categories'); ?>
		<?php echo $form->dropDownList($model, 'categories', CHtml::listData(PostCategory::model()->sort_asc()->findAll(), 'id', 'title'), array('multiple'=>'multiple', 'size'=>10, 'style' => 'width: 400px')); ?>
		<?php echo $form->error($model,'categories'); ?>
	</div>    
    <div class="tinymce">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php echo $form->error($model,'content'); ?>        
        <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
            'model' => $model,
            'attribute' => 'content',
            'editorTemplate' => 'full',
            'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce'),
            )); ?>
    </div>
    <br/>    
    <hr/>
	<div class="row">
		<?php echo $form->labelEx($model,'show_author'); ?>
		<?php echo $form->checkBox($model,'show_author', array()); ?>
		<?php echo $form->error($model,'show_author'); ?>
	</div>    
    
	<div class="row author_info">
		<?php echo $form->labelEx($model,'author_name'); ?>
		<?php echo $form->textField($model,'author_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author_name'); ?>
	</div>

    <div class="row author_info">
		<?php echo $form->labelEx($model,'author_image'); ?>
        <?php if (!$model->isNewRecord && $model->author_image){?>
            <?php echo CHtml::image($model::IMG_AUTHOR_DIR . $model->author_image, '', array('id' => 'author_preview_img', 'width' => 105, 'height' => 75)); ?>
            <span id="del_author_image" style="cursor: pointer">[X]</span>
            <?php echo CHtml::hiddenField('del_author_image_marker', 0); ?>
        <br/><br/>
            
        <?php }?>
		<?php echo $form->fileField($model,'author_image'); ?>
		<?php echo $form->error($model,'author_image'); ?>
	</div>     

    <div class="tinymce author_info">
        <?php echo $form->labelEx($model,'author_content'); ?>
        <?php echo $form->error($model,'author_content'); ?>        
        <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
            'model' => $model,
            'attribute' => 'author_content',
            'editorTemplate' => 'full',
            'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce'),
            )); ?>
    </div>
    <br/>    

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        <?php if (!$model->isNewRecord && !$model->sent){?>
        <?php echo CHtml::submitButton('Send', array('id'=>'send_post_but', 'name'=>'send_but')); ?>
        &nbsp;&nbsp;<a href="<?php echo  Yii::app()->request->baseUrl.$model->url_anckor.'?all=1'; ?>" target="_blank">Website Preview</a>
        &nbsp;&nbsp;<a href="<?php echo $this->createUrl('post/Preview', array('id' => $model->id)); ?>" target="_blank">E-mail Preview</a>
        <?php }?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
    Yii::app()->clientScript->registerScript('imgdel_script',"
    $('#del_author_image').click(function(){
        $('#author_preview_img').hide();
        $('#del_author_image').hide();    
        $('#del_author_image_marker').val(1);
    });
    $('#send_post_but').click(function(e){
        if (!confirm('Do you realy want to send the post to subscribers?')) {
            e.preventDefault();
        }
    });
    $('#Post_show_author').click(function(){
        if ($(this).is(':checked')) {
            $('div').find('.author_info').show('slow');
        } else {
            $('div').find('.author_info').hide('slow');         
        }
    });    
    ".(!empty($_GET['s']) ? 'alert("The post has been sent.")' : '')."
    ",CClientScript::POS_READY);
    
    if (!$model->show_author)
    {
        Yii::app()->clientScript->registerCss('author_css',"
            .author_info{
               display: none;
            }
        ");
    }
?>