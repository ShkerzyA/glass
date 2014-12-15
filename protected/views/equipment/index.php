<?php
/* @var $this EquipmentController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerPackage('customfields');

$this->breadcrumbs=array(
	''.Equipment::$modelLabelP,
);

$this->menu=array(
			
			array('label'=>'Оборудование/ Экспорт', 'url'=>array('/equipment/export'),'htmlOptions'=>array('target'=>'_blank')),
			array('label'=>'Картриджи/ Экспорт', 'url'=>array('/equipmentLog/exportCart'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>'it')))),
			array('label'=>'Заправка картриджей', 'url'=>array('/equipmentLog/Crefill?type=outgo')),
			array('label'=>'Возврат картриджей', 'url'=>array('/equipmentLog/Crefill?type=ingo')),
			array('label'=>'Принтеры/ Статистика', 'url'=>array('/equipmentLog/printersLog'),'htmlOptions'=>array('target'=>'_blank')),
			);

$storage=Workplace::storageCabs();



$this->menu['all_menu']=array(
		array('title'=>'Склады оборудования','items'=>array(
			)
		)
);

foreach ($storage as $v) {
	$this->menu['all_menu'][0]['items'][]=array('label'=>$v['label'], 'url'=>array('/Cabinet/'.$v['url']));
}


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

<div style="position: relative; clear: both;">
   	<table class=phonetable>
   		<tr>
   			<th>Номера</th>
   			<th>Модель</th>
   			<th>Расположение</th>
   			<!--<th>Инвентарный номер</th>-->
   			<th>Состояние</th>
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

</table></div>