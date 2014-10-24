<?php
/* @var $this EquipmentLogController */
/* @var $model EquipmentLog */

$this->breadcrumbs=array(
	'Администрирование'=>array('/admin/index'),
	$model::$modelLabelP=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#equipment-log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление  "<?php  echo $model::$modelLabelP; ?>"</h1>


<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'equipment-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'timestamp',
		array( 'name'=>'subject0subject', 'value'=>'$data->subject0->surname." ".$data->subject0->name." ".$data->subject0->patr' ),
		array( 'name'=>'object0object', 'value'=>'$data->objectEq->inv." ".$data->objectEq->mark' ),
		array( 'name'=>'type', 'value'=>'$data->getType()["name"]' ),
		array( 'name'=>'details', 'value'=>'$data->details()' ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
