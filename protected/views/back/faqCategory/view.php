<?php
/* @var $this FaqCategoryController */
/* @var $model FaqCategory */

$this->breadcrumbs=array(
	'Faq Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List FaqCategory', 'url'=>array('index')),
	array('label'=>'Create FaqCategory', 'url'=>array('create')),
	array('label'=>'Update FaqCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FaqCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FaqCategory', 'url'=>array('admin')),
);
?>

<h1>View FaqCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
