<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */

$this->breadcrumbs=array(
	$model->idCabinet->cname=>array('/cabinet/view/'.$model->idCabinet->id),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать "<?php  echo $model::$modelLabelS; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>