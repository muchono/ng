<?php
/* @var $this SubscriberController */
/* @var $model Subscriber */

$this->breadcrumbs=array(
	'Subscribers'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Subscribers', 'url'=>array('admin')),
);
?>

<h1>Update Subscriber</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>