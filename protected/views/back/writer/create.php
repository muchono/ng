<?php
/* @var $this WriterController */
/* @var $model Writer */

$this->breadcrumbs=array(
	'Writers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Writer', 'url'=>array('index')),
	array('label'=>'Manage Writer', 'url'=>array('admin')),
);
?>

<h1>Create Writer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>