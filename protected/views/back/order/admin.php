<?php
/* @var $this OrderController */
/* @var $model Order */

$this->menu=array(
	array('label'=>'Create Order', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1>Manage Orders</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php //echo $this->renderPartial('//layouts/operations'); ?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
    'cssFile'=> Yii::app()->request->baseUrl . '/css/gridview_orders.css',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>0,
	'columns'=>array(
        array (
            'name' => 'id',
            'htmlOptions' => array('width' => '20', 'align' => 'center'),
        ),        
        array (
            'name' => 'user_email',
            'value' => '$data->user->email',
            'htmlOptions' => array('width' => '150', 'align' => 'center'),
        ),
        array (
            'name' => 'time',
            'type' => 'date',
            'htmlOptions' => array('width' => '20', 'align' => 'center'),
        ),
        array(
            'header' => 'Sites Details',
            'name' => 'products_details',
            'htmlOptions' => array('align' => 'center'),            
            'value' => 'Yii::app()->controller->renderPartial("_order_details", array("data" => $data))',
        ),
        array (
            'name' => 'total',
            'value' => '"$".$data->total',
            'htmlOptions' => array('width' => '30'),
        ),         
        array(
            'name' => 'status',
            'filter' => CHtml::activeDropDownList($model, 'status', Order::$statuses, array('empty' => '')),
            'value' => 'Yii::app()->controller->renderPartial("_order_status", array("data" => $data))',
            'htmlOptions' => array('width' => '80'),            
        ),
		array(
			'class'=>'CButtonColumn',
            'template' => ' {update}',
            'htmlOptions' => array('style' => 'width: 10px'),
		),
	),
));

?>
