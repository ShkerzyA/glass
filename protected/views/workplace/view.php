<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Отобразить "<?php  echo $model::$modelLabelS; ?>"  #<?php echo $model->id; ?></h1> 

<?php $ruleWP=Yii::app()->user->checkAccess('ruleWorkplaces'); ?>
<?php if($ruleWP):?>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/create?Equipment[id_workplace]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить оборудование</div>
</a>
<?php endif; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
array(               
            	'label'=>'Кабинет',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode($model->idCabinet->cname),
                array('Cabinet/view','id'=>$model->idCabinet->id)),
        ),array(               
            	'label'=>'Сотрудник',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode($model->idPersonnel->surname),
                array('Personnel/view','id'=>$model->idPersonnel->id)),
        ),		'wname',
	),
)); ?>
