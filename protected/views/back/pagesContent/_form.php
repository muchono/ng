<?php
/* @var $this PagesContentController */
/* @var $model PagesContent */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pages-content-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="tinymce">
    <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
        'model' => $model,
        'attribute' => 'content',
        'editorTemplate' => 'full',
        //'options' => array('valid_elements' => "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang],a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class],strong/b,em/i,strike,u,#p[style],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width|height|src|*],map[name],area[shape|coords|href|alt|target],bdo,button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|div|valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],q[cite],samp,select[disabled|multiple|name|size],small,textarea[cols|rows|disabled|name|readonly],tt,var,big,article,section,side", 'convert_fonts_to_spans' => false, 'inline_styles' => true),
        'options' => array('forced_root_block' => '', 'extended_valid_elements' => "*[*]", 'custom_elements' => "*[*]",'valid_elements' => "*[*],section[*],side[*],aside[*],article[*],details[*],menu[*],nav[*]", 'custom_elements' => 'article,section', 'convert_fonts_to_spans' => false, 'inline_styles' => true),
        'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce'),
        )); ?>
    </div>    
    <br/>
	<div class="row">
		<?php echo $form->labelEx($model,'href'); ?>
		<?php echo $form->textField($model,'href',array('size'=>60,'maxlength'=>255, 'readonly'=>$model->static)); ?>
        <?php if (!$model->isNewRecord && 0){?>
            <br/><?php echo CHtml::link($this->createAbsoluteUrl('front/content', array('id' => $model->href)), $this->createUrl('front/content', array('id' => $model->href)), array('target' => '_blank')) ?>
        <?php }?>
        
		<?php echo $form->error($model,'href'); ?>
	</div>  
    
    <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>    

<?php $this->endWidget(); ?>

</div><!-- form -->