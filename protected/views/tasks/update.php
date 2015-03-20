<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('helpDesk?id_department='.$model->id_department.'&&group='.implode(',', $model->group)),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);


if(Yii::app()->user->role=='administrator'){
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin')),
);
	$this->menu["details"]=array(array('label'=>'DepartmentPosts', 'url'=>array('DepartmentPosts/admin', 'creator'=>$model->id)),
array('label'=>'DepartmentPosts', 'url'=>array('DepartmentPosts/admin', 'executor'=>$model->id)),
);}
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>