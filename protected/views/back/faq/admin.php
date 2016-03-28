<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->menu=array(
	array('label'=>'Add Question', 'url'=>array('create')),
	array('label'=>'FAQ Categories', 'url'=>array('faqCategory/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#faq-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>FAQs</h1>

<p>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(            
            'name'=>'title',
            'htmlOptions' => array('width' => '320'),
        ),        
        array(            
            'name'=>'categories',
            'value' => '$data->getCategoriesList()',
            'filter'=>CHtml::listData(FaqCategory::model()->sort_asc()->findAll(), 'id', 'title'),
        ),
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update} {delete}',             
		),
	),
)); ?>
