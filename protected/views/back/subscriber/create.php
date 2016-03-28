<?php
/* @var $this SubscriberController */
/* @var $model Subscriber */

$this->breadcrumbs=array(
	'Subscribers'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Subscribers', 'url'=>array('admin')),
);
?>

<h1>Add Subscriber</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>