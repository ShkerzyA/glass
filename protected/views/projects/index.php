<?php
/* @var $this ProjectsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Статистика', 'url'=>array('allStat'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Проекты\Исполнители', 'url'=>array('projectsExecutors'),'visible'=>(Yii::app()->user->role=='administrator')),

);
?>

<h1><?php  echo $modelLabelP; ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
