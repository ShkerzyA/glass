<?php
/* @var $this FloorController */
/* @var $model Floor */

$this->breadcrumbs=array(
	'этаж'=>array('/floor/view/'.$model->id_building),
	$model::$modelLabelP=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать "<?php  echo $model::$modelLabelS; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>