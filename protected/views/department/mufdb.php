<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$model::$modelLabelP,
);

$this->menu=array(
	array('label'=>'Главная', 'url'=>array('tree')),
	array('label'=>'Отделы из MU.dbf', 'url'=>array('mudbf')),
);
?>

<h1>Структура из MU.fdb</h1>

<?php 
 foreach ($result as $v) {
 	echo '<br>'.$v['MU'];
 }
?>
