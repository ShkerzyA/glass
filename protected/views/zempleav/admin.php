<?php
/* @var $this ZempleavController */
/* @var $model Zempleav */

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
	$('#zempleav-grid').yiiGridView('update', {
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
	'id'=>'zempleav-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'empleav_rn',
		'type',
		'startdate',
		'enddate',
		'docdate',
		array('name'=>'orgbaseRnorgbase_rn', 'value'=>'$data->orgbaseRn->fio()' ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
