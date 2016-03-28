<?php
/* @var $this WriterController */
/* @var $model Writer */

$this->breadcrumbs=array(
	'Writers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Writer', 'url'=>array('index')),
	array('label'=>'Create Writer', 'url'=>array('create')),
	array('label'=>'Update Writer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Writer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Writer', 'url'=>array('admin')),
);
?>

<h1>View Writer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'payment_id',
	),
)); ?>
