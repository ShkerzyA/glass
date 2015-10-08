<?php
/* @var $this DocsController */
/* @var $model Docs */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('isOwner',array('mod'=>$model))),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->checkAccess('isOwner',array('mod'=>$model))),
);
	
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>