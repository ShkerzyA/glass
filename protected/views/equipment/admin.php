<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
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
	$('#equipment-grid').yiiGridView('update', {
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



<?php 
$status=Equipment::getStatus();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'equipment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array( 'name'=>'idWorkplaceid_workplace', 'value'=>'$data->getWorkplace()' ),
		'serial',
		'inv',
		array('name'=>'type', 'value'=>'$data->type0->name','filter'=>$model->filterType()),
		array('name'=>'producer', 'value'=>'$data->getProducer()','filter'=>$model->filterProducer()),
		'mark',
		array('name'=>'status', 'value'=>function($data) use ($status) {
            return $status[$data->status];},'filter'=>$model->getStatus()),
		'notes',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
