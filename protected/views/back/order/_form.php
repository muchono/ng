<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="view">
    <?php 
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'time',
            array(
                'label'=>'statusName',
                'type' => 'html',
                'value' => $this->renderPartial("_order_status", array("data" => $model), true),
            ),
            array(
                'label' => 'User',
                'type' => 'raw',
                'value' => CHtml::link($model->user->name, array('user/update', 'id' => $model->user->id), array('target' => '_blank')).' ('.$model->user->email.')',
            ),
            array(
                'name' => 'time_interval',
                'value' => $model->time_interval . ' days',
            ),
            array(
                'name' => 'total',
                'value' => '$'.$model->total,
            ),
            array(
                'name' => 'payment_method',
                'value' => $model->payment_method,
            ),
            array(
                'name' => 'payment_status',
                'value' => $model->payment_status ? 'Paid' : 'Not paid',
            ),
        ),
    )); ?>    
    </div>
	<?php echo $form->errorSummary($model); ?>
        
    <br/>
    <h3 class="prepend-7">Ordered Products:</h3>
    <div class="items">
        <?php foreach ($orderToProduct as $i => $opd) {?>
        
        <div class="view">
        <h3>#<?php echo $i+1;?> - <?php echo CHtml::link(Product::model()->findByPk($opd->product_id)->title, array('product/update', 'id' => $opd->product_id), array('target' => '_blank'));?></h3>            
        <?php echo $form->errorSummary($opd);?>            
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$opd,
            'attributes'=>array(
                'task_date',
                array(
                    'name' => 'price',
                    'value' => '$'.$opd->price,
                ),                
                array(
                    'name' => 'anchor',
                    'type'=>'raw',
                    'value' => CHTML::activeTextField($opd, '['.$opd->id.']anchor', array('size'=>80)),
                ),
                array(
                    'name' => 'url',
                    'type'=>'raw',
                    'value' => CHTML::activeTextField($opd, '['.$opd->id.']url', array('size'=>80)),
                ),                
                array(
                    'name' => 'writerName',
                    'type'=>'raw',
                    'value' => $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                            'model'=>$opd,
                            'attribute'=>'['.$opd->id.']writerName',
                            'source'=>'js:writersNames',
                            'options'=>array(
                                'minLength'=>'1',
                            ),
                        ), true),
                    
                ),
                array(
                    'name' => 'url_res',
                    'type'=>'raw',
                    'value' => CHTML::activeTextField($opd, '['.$opd->id.']url_res', array('size'=>80)),
                ),                
                array(
                    'name' => 'status',
                    'type'=>'raw',
                    'value' => CHtml::activeDropDownList($opd, '['.$opd->id.']status', Order::$statuses),
                ),
                array(
                    'name' => 'comment',
                ),                
            ),
        )); ?> 
        </div>
        <?php }?>        

    </div>     
	<div class="row buttons prepend-8"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save All'); ?></div>

<?php echo CHtml::hiddenField('Order', 1)?>
<?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScript('writers_list_data',"

    var writersNames = [\"".join('", "', $writers_names)."\"];
    
",CClientScript::POS_HEAD);?>