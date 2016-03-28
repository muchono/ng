<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Blog Posts'=>array('admin'),
	'Add',
);

$this->menu=array(
	array('label'=>'Blog Posts', 'url'=>array('admin')),
);
?>

<h1>Add Post</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>