<?php
/* @var $this PostCategoryController */
/* @var $model PostCategory */

$this->breadcrumbs=array(
	'Blog'=>array('post/admin'),
	'Post Categories'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Post Categories', 'url'=>array('admin')),
);
?>

<h1>Update Category <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>