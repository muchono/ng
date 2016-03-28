<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	//'Новости'=>array('admin'),
	//$model->title=>array('view','id'=>$model->id),
	//'Редактирование',
);

$this->menu=array(
	array('label'=>'Создание новости', 'url'=>array('create')),
	array('label'=>'Список новостей', 'url'=>array('admin')),
);
?>

<h1>Редактирование новости</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>