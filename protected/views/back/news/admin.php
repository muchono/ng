<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	//'Manage',
);

$this->menu=array(
	array('label'=>'Создать Новости', 'url'=>array('create')),
);
?>

<h1>Список новостей</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'date_added',
            'htmlOptions'=>array('width' => '100'),
        ),
		'title',
		array(
            'name'=>'active',
            'filter'=>Yii::app()->format->booleanFormat,
            'value'=>'$data->active ? "да" : "нет"',
            'htmlOptions' => array('width' => '20'),
        ),
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update} {delete}',
		),
	),
)); ?>
