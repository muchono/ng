<?php
/* @var $this WriterController */
/* @var $model Writer */

$this->breadcrumbs=array(
	'Writers'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List Writer', 'url'=>array('index')),
	array('label'=>'Create Writer', 'url'=>array('create')),
	array('label'=>'View Writer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Writer', 'url'=>array('admin')),
);
?>

<h1>Update Writer <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>