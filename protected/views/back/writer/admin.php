<?php
/* @var $this WriterController */
/* @var $model Writer */

$this->menu=array(
	array('label'=>'List Writer', 'url'=>array('index')),
	array('label'=>'Create Writer', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#writer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

var previous_status;
var active_task_status;
$('.progress_select').on('focus', function () {
        previous_status = $(this).val();
    }).change(function(){
    active_task_status = $(this);
    
    if (active_task_status.val() == ".Order::FINISH_STATUS.") {
        var matches =active_task_status.attr('name').match(/\[(\d+)\]/);
        $('#OrderToProduct_id').val(matches[1]);
        $('#deliverydialog').dialog('open');
        return false;
    }
    
    previous_status = active_task_status.val();
    saveStatus(active_task_status);
});

function saveStatus(trig){
    var matches = trig.attr('name').match(/\[(\d+)\]/);
    var el_trig = trig.closest('td');
    $.ajax({
        url: '".$this->createUrl('task/updateStatusAjax')."&id='+matches[1]+'&status='+trig.val(),
        dataType:'json',
        beforeSend: function( xhr ) {
            el_trig.prop('class', '');
        }
    }).done(function(data) {
        if (data.res) {
            $('#loader_' + matches[1] + ' img').show(0, function(){
                setTimeout(function() {
                    $('#loader_' + matches[1] + ' img').hide('slow');
                }, 1000);                

            });
            $('#date_start_' + data.data.id).html(data.data.status == ".Order::PROCESS_STATUS."?data.data.date_start:'');
            el_trig.addClass('status_' + data.data.status);
            
        } else {
            var str = '';
            $.each(data.messages, function(id,val) {                    
                str += val + ' ';
            });
            console.log(str);
        }
    });
}
");
?>

<h1>Writers</h1>
<p></p>
<span class="writers_tasks span-12">
    <span class="span-3 bold"><b>Tasks colors:</b></span>
    <?php foreach(Order::$statuses as $sid=>$sname){?>
        <span class="span-2 status_<?php echo $sid?>"><?php echo $sname?></span>
    <?php }?>
</span>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'writer-grid',
    'cssFile'=>'css/cgridview.css',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,    
	'columns'=>array(
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("writer/update", "id" => $data->id), array("target" => "_blank"))',
            'htmlOptions'=>array(
                'width'=>100,
                'style'=>'text-align: center;',
            ),
        ),
        array(
            'name' => 'payment_id',
            'htmlOptions'=>array(
                'width'=>100,
                'style'=>'text-align: center;',
            ),
        ),        
        array(
            'header' => 'Tasks',
            'value' => 'Yii::app()->controller->renderPartial("_task_details", array("data" => $data))',
        ),
	),
)); 


$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'deliverydialog',
    'options'=>array(
        'title'=>'Post Url',
        'autoOpen'=>false,
        'height'=> 160,
        'width'=> 450,
        'modal'=>true,
        'close' => 'js:function(event, ui) { 
            active_task_status.val(previous_status);
            $("#OrderToProduct_url_res").val("");
        }'
    ),
));?>
<?php   $form=$this->beginWidget(
            'CActiveForm',
            array(
                'id'                      => 'deliverydialog-form',
                'action'=>Yii::app()->createUrl('task/updateURLAjax'),
                'enableAjaxValidation'  => true,
                'clientOptions'         => array(
                                                'validateOnSubmit'=>true,
                                                'afterValidate' => "js: function(form, data, hasError) {
                                                    //if no error in validation, send form data with Ajax
                                                    if (!hasError) {
                                                        previous_status = active_task_status.val();
                                                        saveStatus(active_task_status);
                                                        $('#deliverydialog').dialog('close');
                                                    }
                                                }"
               )
            )
        );
        $op = OrderToProduct::model();
?>
<div class="row">
    <?php echo $form->hiddenField($op,'id'); ?>
    <?php echo $form->labelEx($op,'url_res'); ?>
    <?php echo $form->textField($op,'url_res',array('size'=>40,'maxlength'=>500)); ?>
    <?php echo $form->error($op,'url_res'); ?>
</div>
<br/>
<div class="row buttons" style="text-align: center;">
    <?php echo CHtml::submitButton('Save'); ?>
</div>

<?php
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


