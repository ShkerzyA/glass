<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */

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
	$this->menu["details"]=array(array('label'=>'Персонал', 'url'=>array('Personnel/admin', 'id_personnel'=>$model->id)),
							array('label'=>'Кабинет', 'url'=>array('Cabinet/admin', 'id_cabinet'=>$model->id)),
							array('label'=>'Оборудование', 'url'=>array('Equipment/admin', 'id_workplace'=>$model->id)),
);
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>