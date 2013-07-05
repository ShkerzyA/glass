<?php
/* @var $this FloorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	$model->modelLabelP=>array('index'),
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1><?php  echo $model->modelLabelP; ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
