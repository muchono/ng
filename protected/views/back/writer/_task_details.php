<table class="writers_tasks" style="margin-bottom: 0; margin-top: 1em; ">
<?php foreach ($data->tasks as $task) {?>
    <tr>
        <td style="text-align: center;"><?php echo CHtml::link($task->product->title, array('product/update', 'id' => $task->product_id), array('target' => '_blank'));?> for <?php echo CHtml::link($task->product->url, $task->product->url, array('target' => '_blank'));?></td>
        <td style="width: 60px;"><span id="date_start_<?php echo $task->id;?>"><?php echo $task->status == Order::PROCESS_STATUS ? $task->date_start : ''?></td>
        <td class="status_<?php echo $task->status;?>" style="width: 110px;"><?php echo CHtml::dropDownList('status['.$task->id.']', $task->status, Order::$statuses, array("class" => "progress_select"));?><span id="loader_<?php echo $task->id;?>">&nbsp;<img src="img/save.png" style="display: none"/></span></td>
    </tr>
<?php }?>
</table>