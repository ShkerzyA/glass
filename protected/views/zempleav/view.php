<?php
/* @var $this ZempleavController */
/* @var $model Zempleav */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->empleav_rn,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->empleav_rn)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->empleav_rn),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Отобразить "<?php  echo $model::$modelLabelS; ?>"  #<?php echo $model->empleav_rn; ?></h1> 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'reason',
	),
)); ?>
