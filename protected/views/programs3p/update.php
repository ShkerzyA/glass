<?php
/* @var $this Programs3pController */
/* @var $model Programs3p */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
	
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>