<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs=array(
	'Sites'=>array('product/'),
	'List of Categories'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List of Categories', 'url'=>array('admin')),
);
?>

<h1>Create Site Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>