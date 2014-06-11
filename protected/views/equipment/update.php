<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Рабочее место'=>array('/Workplace/view/'.$model->id_workplace),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
	$this->menu["details"]=array(array('label'=>'Workplace', 'url'=>array('Workplace/admin', 'id_workplace'=>$model->id)),
);
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>