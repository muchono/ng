<?php
/* @var $this FaqCategoryController */
/* @var $model FaqCategory */

$this->breadcrumbs=array(
	'FAQs'=>array('faq/admin'),
	'FAQ Categories'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'FAQ Categories', 'url'=>array('admin')),
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'FAQs', 'url'=>array('faq/admin')),
);
?>

<h1>Update Category <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>