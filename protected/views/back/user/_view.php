<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_num')); ?>:</b>
	<?php echo CHtml::encode($data->orders_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('websites_num')); ?>:</b>
	<?php echo CHtml::encode($data->websites_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribe')); ?>:</b>
	<?php echo CHtml::encode($data->subscribe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />


</div>