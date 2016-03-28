<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	//'News'=>array('admin'),
	//'Create',
);

$this->menu=array(
	array('label'=>'Список новостей', 'url'=>array('admin')),
);
?>

<h1>Создать новости</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>