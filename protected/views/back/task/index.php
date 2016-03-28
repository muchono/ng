<?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array('Tasks');
?>

<h1>Tasks for <?php echo $date?></h1>
<div style="font-size: 10px">
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'task_date',
    'value'=>$date,
    //'flat' => true,
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=> "dd/mm/yy"
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
</div>
<br/>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$activeList,
    'viewData' => array(
        'statuses'=>$statuses,
    ),
	'itemView'=>'_view',
)); ?>

<?php if (!$activeList->getItemCount()) {?>
<div style="height: 400px"></div>
<?php }?>

<?php Yii::app()->clientScript->registerScript('writerscripts',"
    $('#task_date').change(function(){
        window.location.replace('".$this->createUrl('task/')."&task_date=' + $(this).val());
    });
",CClientScript::POS_READY);?>

<?php Yii::app()->clientScript->registerScript('writers_list_data',"

    var writersNames = [\"".join('", "', $writers_names)."\"];
    
",CClientScript::POS_HEAD);?>