<?php
/* @var $this FaqCategoryController */
/* @var $model FaqCategory */

$this->breadcrumbs=array(
	'FAQs'=>array('faq/admin'),
	'FAQ Categories'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'FAQ Categories', 'url'=>array('admin')),
	array('label'=>'FAQs', 'url'=>array('faq/admin')),
);
?>

<h1>Create Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>