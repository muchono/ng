<?php
/* @var $this OrderToProductController */
/* @var $model OrderToProduct */

$this->breadcrumbs=array(
	'Order To Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderToProduct', 'url'=>array('index')),
	array('label'=>'Manage OrderToProduct', 'url'=>array('admin')),
);
?>

<h1>Create OrderToProduct</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>