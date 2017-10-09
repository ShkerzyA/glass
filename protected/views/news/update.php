<?php
/* @var $this NewsController */
/* @var $model News */

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
	$this->menu["details"]=array(array('label'=>'Personnel', 'url'=>array('Personnel/admin', 'creator'=>$model->id)),
array('label'=>'Files', 'url'=>array('Files/admin', 'files_throw(id_news,id_file)'=>$model->id)),
);
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>