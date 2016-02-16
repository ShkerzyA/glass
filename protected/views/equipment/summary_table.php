<?php
/* @var $this EquipmentController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerPackage('customfields');

$this->breadcrumbs=array(
	''.Equipment::$modelLabelP,
);

$this->renderPartial('adminMenu',array());
foreach ($models as $model) {
	echo $model->mac.'<br>';
}
?>