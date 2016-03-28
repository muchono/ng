<?php
/* @var $this OrderToProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order To Products',
);

$this->menu=array(
	array('label'=>'Create OrderToProduct', 'url'=>array('create')),
	array('label'=>'Manage OrderToProduct', 'url'=>array('admin')),
);
?>

<h1>Order To Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
