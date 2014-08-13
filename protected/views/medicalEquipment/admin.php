<?php
/* @var $this MedicalEquipmentController */
/* @var $model MedicalEquipment */

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
	$('#medical-equipment-grid').yiiGridView('update', {
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
	'id'=>'medical-equipment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'date',
		'cnum',
		'name',
		'date_exp',
		'number_research',
		'name_research',
		/*
		'fio_pac',
		'diag',
		'birthday',
		'fio_sender',
		'conclusion',
		'number_downtime',
		'eed',
		'reason_downtime',
		'measures_taken',
		'id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
