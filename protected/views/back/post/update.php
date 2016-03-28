<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Blog Posts'=>array('admin'),
	'Edit',
);

$this->menu=array(
	array('label'=>'Add Post', 'url'=>array('create')),
	array('label'=>'Blog Posts', 'url'=>array('admin')),
);
?>

<h1>Edit Post</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>