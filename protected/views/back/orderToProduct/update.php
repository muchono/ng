<?php
/* @var $this OrderToProductController */
/* @var $model OrderToProduct */

$this->breadcrumbs=array(
	'Order To Products'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderToProduct', 'url'=>array('index')),
	array('label'=>'Create OrderToProduct', 'url'=>array('create')),
	array('label'=>'View OrderToProduct', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderToProduct', 'url'=>array('admin')),
);
?>

<h1>Update OrderToProduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>