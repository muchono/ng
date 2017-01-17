<?php
/* @var $this ProductController */
/* @var $model Product */

$this->menu=array(
	array('label'=>'Create Site', 'url'=>array('create')),
	array('label'=>'Site Categories', 'url'=>array('productCategory/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="span-17">
    <h1>Sites</h1>
    <p>
    <br/>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>
</div>
<?php echo $this->renderPartial('//layouts/operations'); ?>

<!--
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
-->
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,    
	'columns'=>array(
        array(
            'name'=>'title',
            'htmlOptions' => array('width' => '200', 'align' => 'center'),
        ),        
        array(
            'name'=>'orders',
            'htmlOptions' => array('width' => '10', 'align' => 'center'),
        ),
        array(            
            'name'=>'categories',
            'value' => '$data->getCategoriesList()',
            'filter'=>CHtml::listData(ProductCategory::model()->sort_asc()->findAll(), 'id', 'title'),
        ),
        array(
            'name'=>'price',
            'value'=>'"$".$data->price',
            'htmlOptions' => array('width' => '40', 'align' => 'center'),
        ),
        array(
            'name'=>'status',
            'value' => '$data->getStatusName()',
            'htmlOptions' => array('width' => '10', 'align' => 'center'),
            'filter' => Product::$statuses,
        ),        
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update}', 
		),
	),
)); ?>
