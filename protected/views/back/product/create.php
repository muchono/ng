<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Sites'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Sites', 'url'=>array('admin')),
);
?>

<h1>Create Site</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>