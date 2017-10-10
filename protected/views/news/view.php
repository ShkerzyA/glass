<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1><?php echo $model->name?></h1> 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
array(               
            	'label'=>'Personnel',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode($model->creator0->fio_full()),array('Personnel/view','id'=>$model->creator0->id)),
        ),	
array(               
            	'label'=>'Файлы',
            	'type'=>'raw',
            	'value'=>$model->FileModel->attachedFilesView()),

array(               
            	'label'=>'Текст',
            	'type'=>'raw',
            	'value'=>$model->FileModel->attachInText($model->text)),



))); ?>
