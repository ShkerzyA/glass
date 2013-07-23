<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */

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
	$('#workplace-grid').yiiGridView('update', {
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
	'id'=>'workplace-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array( 'name'=>'idCabinetid_cabinet', 'value'=>'$data->idCabinet->idFloor->idBuilding->bname."/".$data->idCabinet->idFloor->fname."/".$data->idCabinet->cname." #".$data->idCabinet->num'),
		array( 'name'=>'idPersonnelid_personnel', 'value'=>'$data->idPersonnel->surname." ".$data->idPersonnel->name." ".$data->idPersonnel->patr' ),
		'wname',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
