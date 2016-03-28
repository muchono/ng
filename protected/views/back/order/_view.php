<?php
/* @var $this OrderController */
/* @var $data Order */
?>

<div class="view form">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
    )); ?>
    <?php echo $form->errorSummary($data); ?>
    <h4>Post in <b><?php echo $data->product->title?></b> for <?php echo CHtml::link('URL', $data->product->url, array('target' => '_blank'));?></h4>
    <table>
        <tr><td>
            <div class="span-2"><b><?php echo $data->getAttributeLabel('anchor'); ?>: </b></div><?php echo  CHTML::activeTextField($data, 'anchor', array('readonly' => 'readonly', 'size' => '51')) ?><br />
            <div class="span-2"><b><?php echo $data->getAttributeLabel('comment'); ?>: </b></div><?php echo CHTML::activeTextArea($data, 'comment', array('readonly' => 'readonly', 'cols' => '38')) ?><br />
            </td>
            <td>
                <b><?php echo $data->getAttributeLabel('status'); ?>: </b><?php echo CHtml::activeDropDownList($data, 'status', Order::$statuses);?><br />
                <b><?php echo $data->getAttributeLabel('writerName'); ?>: </b><?php echo  CHTML::activeTextField($data, 'writerName', array('size' => '31')) ?><br />
                <div class="buttons prepend-2"><?php echo CHtml::submitButton('Save'); ?></div>
            </td>
       </tr>
       </table>       
    <?php $this->endWidget(); ?>
</div>