<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs=array(
	'Sites'=>array('product/'),
	'List of Categories'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List of Categories', 'url'=>array('admin')),
	array('label'=>'Create Category', 'url'=>array('create')),
);
?>

<h1>Update Category "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>