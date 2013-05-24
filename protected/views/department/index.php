<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Отделы',
);

$this->menu=array(
	array('label'=>'Создать отдел', 'url'=>array('create')),
	array('label'=>'Управление отделами', 'url'=>array('admin')),
	array('label'=>'Отделы(дерево)', 'url'=>array('tree')),
);
?>

<h1>Отделы</h1>

 <?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?> 
