<?php
/* @var $this MessagesController */
/* @var $model Messages */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Создать "<?php  echo $model::$modelLabelS; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>