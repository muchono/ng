<?php
/* @var $this OrderToProductController */
/* @var $model OrderToProduct */

$this->breadcrumbs=array(
	'Order To Products'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderToProduct', 'url'=>array('index')),
	array('label'=>'Create OrderToProduct', 'url'=>array('create')),
	array('label'=>'Update OrderToProduct', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderToProduct', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderToProduct', 'url'=>array('admin')),
);
?>

<h1>View OrderToProduct #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'product_id',
		'anchor',
		'comment',
		'status',
		'writerName',
		'price',
	),
)); ?>
