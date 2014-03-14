<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h2>Создать событие <?php  echo($model->date.' в помещении "'.$model->idRoom->idCabinet->cname.' '.$model->idRoom->idCabinet->num); ?>"</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>