<?php
/* @var $this PagesContentController */
/* @var $model PagesContent */

$this->breadcrumbs=array(
	//'Manage',
);

$this->menu=array(
	array('label'=>'Add new', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pages-content-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Pages List</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pages-content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,    
	'columns'=>array(
		'name',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
             'buttons'  => array(
                'delete' => array(
                    'visible' => '!$data->static', // assumes model has canDelete attribute
                )           
            ),
		),
	),
)); ?>
