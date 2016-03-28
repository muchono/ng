<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'FAQs'=>array('index'),
	'Update',
);

$this->menu=array(
    array('label'=>'Add Question', 'url'=>array('create')),
	array('label'=>'FAQs', 'url'=>array('admin')),
	array('label'=>'FAQ Categories', 'url'=>array('faqCategory/admin')),    
);
?>

<h1>Update</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>