<?php
/* @var $this PostCategoryController */
/* @var $model PostCategory */

$this->breadcrumbs=array(
	'Blog'=>array('post/admin'),
	'Post Categories'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Post Categories', 'url'=>array('admin')),
);
?>

<h1>Create Post Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>