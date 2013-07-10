<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin')),
);
	$this->menu["details"]=array(array('label'=>'UsersRules', 'url'=>array('UsersRules/admin', 'id_user'=>$model->id)),
array('label'=>'UsersPosts', 'url'=>array('UsersPosts/admin', 'id_post'=>$model->id)),
array('label'=>'Personnel', 'url'=>array('Personnel/admin', 'id_user'=>$model->id)),
);
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>