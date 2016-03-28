<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Sites'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Site', 'url'=>array('create')),
	array('label'=>'Sites', 'url'=>array('admin')),
);
?>

<h1>Update Site "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>