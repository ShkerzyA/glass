<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
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