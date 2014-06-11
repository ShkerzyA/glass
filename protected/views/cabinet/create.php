<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

$this->breadcrumbs=array(
	$model->idFloor->idBuilding->bname=>array('/building/view/'.$model->idFloor->idBuilding->id),
	$model->idFloor->fname=>array('/floor/view/'.$model->idFloor->id),
	$model->cname,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать "<?php  echo $model::$modelLabelS; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>