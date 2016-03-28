<?php
/* @var $this OrderController */
/* @var $data Order */
?>

<div class="view form">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form-'.$data->id,
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
    )); ?>
    <?php echo $form->errorSummary($data);?>
    <h4>Post on <b><?php echo CHtml::link($data->product->title, $this->createUrl('product/update', array('id'=>$data->product->id)), array('target' => '_blank'));?></b> for <?php echo CHtml::link(substr($data->url, 0,60).(strlen($data->url) > 60 ? '...' : ''), $data->url, array('target' => '_blank'));?></h4>
    <table border="1">
        <tr>
            <td style="width: 440px; border-right: 1px solid #c9e0ed;">
                <div style="padding: 20px 0 0 80px">
                <div class="span-3"><b><?php echo $data->getAttributeLabel('status'); ?>: </b></div><?php echo CHtml::activeDropDownList($data, '['.$data->id.']status', $statuses);?><br />
                <div class="span-3"><b><?php echo $data->getAttributeLabel('writerName'); ?>: </b></div>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    //'id'=>'writerName_'.$data->id,
                    'model'=>$data,
                    'attribute'=>'['.$data->id.']writerName',
                    //'name'=>'writerName',
                    //'value'=>!empty($data->writer) ? $data->writer->name : '',
                    'source'=>'js:writersNames',
                    'options'=>array(
                        'minLength'=>'1',
                    ),
                    'htmlOptions'=>array(
                        //'style'=>'height:31px;',
                    ),
                ));  
                 ?> 


                <?php //echo  CHTML::activeTextField($data, 'writerName', array('size' => '31')) 
                        ?>
                <?php echo $form->error($data,'['.$data->id.']writerName'); ?>
                <br />
                <?php echo CHtml::activeHiddenField($data, '['.$data->id.']id')?>
                <div class="buttons prepend-2"><?php echo CHtml::submitButton('Save'); ?></div>
                </div>
            </td>
            <td>
            </td>

            <td >
                <div class="span-2"><b><?php echo $data->getAttributeLabel('anchor'); ?>: </b></div><i><?php echo empty($data->anchor) ? '<i>no anchor</i>' : CHtml::encode($data->anchor); ?></i><br />
                <div class="span-2"><b><?php echo $data->getAttributeLabel('comment'); ?>: </b></div><?php echo empty($data->comment) ? '<i>no comments</i>' : CHtml::encode($data->comment); ?><br />
            </td>            
       </tr>
       </table>       
    <?php $this->endWidget(); ?>
</div>