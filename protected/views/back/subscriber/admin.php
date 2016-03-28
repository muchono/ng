<?php
/* @var $this SubscriberController */
/* @var $model Subscriber */

$this->menu=array(
	array('label'=>'Add Subscriber', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subscriber-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Subscribers</h1>

<p>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'subscriber-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'email',
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update} {delete}',              
		),
	),
)); ?>
