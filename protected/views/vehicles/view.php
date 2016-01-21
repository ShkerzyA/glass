<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#','visible'=>Yii::app()->user->role=='administrator', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Лог', 'url'=>'#','visible'=>(Yii::app()->user->checkAccess('inGroup',array('it'))),'linkOptions'=>array('class'=>'showlogUni','id'=>$model->id,'mod'=>get_class($model)),)
);
?>

<h1><?php  echo $model::$modelLabelS; ?>  <?php echo $model->nameL(); ?></h1> 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
            'name'=>'owner',
            'value'=>$model->ownerName(),
        ),
		array('name'=>'mark',
            'value'=>$model->markName()),
		'number',
		array('name'=>'deactive',
			'value'=>$model->isDeactive()),
		array('name'=>'status',
			'value'=>$model->getStatus()),
		
        array(
        	'name'=>'shedule',
        	'type'=>'html',
        	'value'=>$model->StrShedule(),
        	),

	),
)); ?>
