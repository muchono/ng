<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs=array(
	'Sites'=>array('product/'),
	'List of Categories',
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
	$('#product-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Sites Categories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<!--
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
-->
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,    
	'columns'=>array(
		'title',
		array(
            'name'=>'view_num',
            'htmlOptions' => array('width' => '60', 'align' => 'center'),
        ),         
		array(
            'name'=>'sale_num',
            'htmlOptions' => array('width' => '60', 'align' => 'center'),
        ),
		array(
            'name'=>'coefficient',
            'htmlOptions' => array('width' => '60', 'align' => 'center'),
        ),        
		array(
            'name'=>'product_num',
            'htmlOptions' => array('width' => '60', 'align' => 'center'),
        ),  
		array(
            'name'=>'product_general_num',
            'htmlOptions' => array('width' => '60', 'align' => 'center'),
        ),         
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update}',   
            'buttons'  => array(
                'delete' => array(
                    'visible' => '$data->editable', // assumes model has canDelete attribute
                ),
                'delete' => array(
                    'visible' => '$data->editable', // assumes model has canDelete attribute
                )
            ),            
		),
	),
)); ?>
