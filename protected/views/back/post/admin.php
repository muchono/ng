<?php
/* @var $this PostController */
/* @var $model Post */

$this->menu=array(
	array('label'=>'Add Post', 'url'=>array('create')),
	array('label'=>'Post Categories', 'url'=>array('postCategory/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#post-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Blog Posts</h1>

<p></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,    
	'columns'=>array(
        array(            
            'name'=>'title',
            'htmlOptions' => array('width' => '320'),
        ),        
        array(            
            'name'=>'categories',
            'value' => '$data->getCategoriesList()',
            'filter'=>CHtml::listData(PostCategory::model()->sort_asc()->findAll(), 'id', 'title'),
        ),
		array(
            'name'=>'active',
            'filter'=>Yii::app()->format->booleanFormat,
            'value'=>'$data->active ? "yes" : "no"',
            'htmlOptions' => array('width' => '50', 'align' => 'center'),
        ),        
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update} {delete}',            
		),
	),
)); ?>
