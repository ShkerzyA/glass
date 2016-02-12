<?php
/* @var $this EquipmentController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerPackage('customfields');

$this->breadcrumbs=array(
	''.Equipment::$modelLabelP,
);

$this->menu=array(
			
			array('label'=>'Оборудование/ Экспорт', 'url'=>array('/equipment/export'),'htmlOptions'=>array('target'=>'_blank')),
			array('label'=>'Картриджи/ Экспорт', 'url'=>array('/equipmentLog/exportCart'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it'))))),
			array('label'=>'Заправка картриджей', 'url'=>array('/equipmentLog/Crefill?type=outgo')),
			array('label'=>'Возврат заправленных', 'url'=>array('/equipmentLog/Crefill?type=ingo')),
			array('label'=>'Возврат востановленных', 'url'=>array('/equipmentLog/Crefill?type=ingo_r')),
			array('label'=>'Принтеры/ Статистика', 'url'=>array('/equipmentLog/printersLog'),'htmlOptions'=>array('target'=>'_blank')),
			array('label'=>'Картриджи/ Сводная таблица', 'url'=>array('/equipment/commonCartInfo'),'htmlOptions'=>array('target'=>'_blank')),
			);

?>