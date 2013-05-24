<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кадры',
);
if (Yii::app()->user->name=='admin'){
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление кадрами', 'url'=>array('admin')),
);
}
?>

<h1>Кадры</h1>

<?php 
//$dataProvider->itemCount=$dataProvider->getItemCount();

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_indexview',
)); ?>
