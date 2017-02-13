<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),    
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php if(!$model->isNewRecord){?>
    <div class="view">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'orders',
            'google_pr',
            'alexa_rank',
            'da_rank',
            'stat_update_date',
        ),
    )); ?>    
    </div>
    <?php }?>


	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
        <?php if (!$model->isNewRecord && $model->image){?>
            <?php echo CHtml::image($model::IMG_DIR . $model->image, '', array('id' => 'preview_img', 'width' => 180, 'height' => 140)); ?>
            <?php echo CHtml::hiddenField('del_image_marker', 0); ?>
        <br/><br/>
            
        <?php }?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>    
	
    <div class="row">
        <?php echo $form->labelEx($model,'categories'); ?>
		<?php echo $form->dropDownList($model, 'categories', CHtml::listData(ProductCategory::model()->sort_asc()->findAll(), 'id', 'title'), array('multiple'=>'multiple', 'size'=>15, 'width' => '500')); ?>
		<?php echo $form->error($model,'categories'); ?>
	</div>
    <div class="tinymce">
        <?php echo $form->labelEx($model,'about'); ?>
        <?php echo $form->error($model,'about'); ?>        
        <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
            'model' => $model,
            'attribute' => 'about',
            'editorTemplate' => 'full',
            'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce'),
            )); ?>
    </div>  
        <br/>  
	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
        <?php echo $form->dropDownList($model, 'link', Product::$links, array('empty' => '')); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anchor'); ?>
        <?php echo $form->dropDownList($model, 'anchor', Product::$anchors); ?>
		<?php echo $form->error($model,'anchor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Product::$statuses); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'traffic'); ?>
		<?php echo $form->textField($model,'traffic'); ?>
        <?php if(!$model->isNewRecord){?>(<?php echo (int)$model->traffic_update_months; ?> month(s) ago)<?php }?>
        
		<?php echo $form->error($model,'traffic'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
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