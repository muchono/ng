<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'FAQs'=>array('admin'),
);

$this->menu=array(
	array('label'=>'FAQs', 'url'=>array('faq/admin')),
	array('label'=>'FAQ Categories', 'url'=>array('faqCategory/admin')),    
);
?>

<h1>Create FAQ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>