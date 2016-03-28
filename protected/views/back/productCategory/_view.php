<?php
/* @var $this ProductCategoryController */
/* @var $data ProductCategory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('view_num')); ?>:</b>
	<?php echo CHtml::encode($data->view_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_num')); ?>:</b>
	<?php echo CHtml::encode($data->sale_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_num')); ?>:</b>
	<?php echo CHtml::encode($data->product_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_general_num')); ?>:</b>
	<?php echo CHtml::encode($data->product_general_num); ?>
	<br />


</div>