<?php
/* @var $this FaqCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Faq Categories',
);

$this->menu=array(
	array('label'=>'Create FaqCategory', 'url'=>array('create')),
	array('label'=>'Manage FaqCategory', 'url'=>array('admin')),
);
?>

<h1>Faq Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
