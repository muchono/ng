<?php
/* @var $this PostCategoryController */
/* @var $model PostCategory */

$this->breadcrumbs=array(
	'Blog'=>array('post/admin'),
	'Post Categories',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#post-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Post Categories</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,    
	'columns'=>array(
		'title',
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update} {delete}',
		),
	),
)); ?>
