<?php
/* @var $this FloorController */
/* @var $model Floor */

$this->breadcrumbs=array(
	$model->modelLabelP=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin')),
);
?>

<h1>Изменить "<?php  echo $model->modelLabelS; ?>"  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>