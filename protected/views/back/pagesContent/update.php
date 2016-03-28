<?php
/* @var $this PagesContentController */
/* @var $model PagesContent */

$this->breadcrumbs=array(
	//'Pages Contents'=>array('admin'),
	//'Update',
);

$this->menu=array(
	array('label'=>'Add new', 'url'=>array('create')),
	array('label'=>'Pages Content List', 'url'=>array('admin')),
);
?>

<h1>Update Content</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>