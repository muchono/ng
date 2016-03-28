<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>Order #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'orderToProduct'=>$orderToProduct, 'writers_names'=>$writers_names)); ?>