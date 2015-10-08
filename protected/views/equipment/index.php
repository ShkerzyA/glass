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
			array('label'=>'Возврат картриджей', 'url'=>array('/equipmentLog/Crefill?type=ingo')),
			array('label'=>'Принтеры/ Статистика', 'url'=>array('/equipmentLog/printersLog'),'htmlOptions'=>array('target'=>'_blank')),
			array('label'=>'Картриджи/ Сводная таблица', 'url'=>array('/equipment/commonCartInfo'),'htmlOptions'=>array('target'=>'_blank')),
			);


$this->renderPartial('/workplace/storages');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#equipment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div style="clear: both"></div>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<br><br>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<h1 style="clear: both"><?php  echo Equipment::$modelLabelP; ?></h1>

<?php 
?>

<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];
$status=Equipment::getStatus();


$rul=Yii::app()->user->checkAccess("ruleWorkplaces");
?>
<?php echo CHtml::beginForm('/glass/Equipment/massUpd','post'); ?>
<?php $this->renderPartial('/workplace/massUpd'); ?>
<div style="position: relative; clear: both;">
<div style="clear: both"></div>
   	<table class=phonetable>
   		<tr>
   			<th>Номера</th>
   			<th>Модель</th>
   			<th>Расположение</th>
   			<!--<th>Инвентарный номер</th>-->
   			<th>Состояние/Дата выпуска</th>
   			<th>Примечания</th>

            <?php if($rul) echo '<th>Редактировать</th>'; ?>
   		</tr>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_viewindex',
	'viewData' => array(
   		'rul' => $rul,  
   		'status' => $status,       
 	),
)); ?>

</table>
</div>
<?php echo CHtml::endForm(); ?>