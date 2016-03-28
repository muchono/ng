<?php
/* @var $this PagesContentController */
/* @var $model PagesContent */

$this->breadcrumbs=array(
	//'Pages Contents'=>array('admin'),
	//'Create',
);

$this->menu=array(
	array('label'=>'Pages Content List', 'url'=>array('admin')),
);
?>

<h1>Add Content</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>