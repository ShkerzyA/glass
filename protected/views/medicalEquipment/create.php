<?php
/* @var $this MedicalEquipmentController */
/* @var $model MedicalEquipment */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('plan'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Добавить запись</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>