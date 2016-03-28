<?php
/* @var $this WriterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Writers',
);

$this->menu=array(
	array('label'=>'Create Writer', 'url'=>array('create')),
	array('label'=>'Manage Writer', 'url'=>array('admin')),
);
?>

<h1>Writers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
