<?php
/* @var $this EquipmentController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerPackage('customfields');

$this->breadcrumbs=array(
	''.Equipment::$modelLabelP,
);

$this->menu=array(
				//array('label'=>'Сводная таблица сетевого оборудования', 'url'=>array('/Equipment/summaryTable')),
				array('label'=>'DHCP=>EQ', 'url'=>array('/Equipment/dhcpWithEq')),
				array('label'=>'EQ=>DHCP', 'url'=>array('/Equipment/netEqWithDhcp')),
				//array('label'=>'IP и MAC по имени хоста', 'url'=>array('#')),
				//array('label'=>'IP и хост по маку', 'url'=>array('#')),
			);

?>