<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */

$this->breadcrumbs=array(
	'Мед. оборудование',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#medical-equipment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<input name="print" class="hide_p" type="button" style="float: right; width: 200px; height: 30px"value="Печать" onclick="window.print();"> 
<a target="_blank" href="/glass/medicalEquipment/export?MedicalEquipment[creator]=<?php echo $model->creator ?>&&MedicalEquipment[date]=<?php echo $model->date?>&&MedicalEquipment[date_end]=<?php echo $model->date_end?>">
		<div id="add_task" class="add_unit fl_right" style="float: right; width: 200px">Экспорт в xls</div>
	</a>
<a href="/glass/medicalEquipment/create">
		<div id="add_task" class="add_unit fl_right" style="float: right; width: 200px">Добавить запись</div>
	</a>
<div style="margin: 3px">
<?php echo CHtml::link('','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:block">
<?php $this->renderPartial('_search',array('model'=>$model,)); ?>
</div>
<br>
<br>
<br>
<!-- search-form -->
<h2 style="text-align: center; margin: 0px;">Мониторинг работы медицинского оборудования</h2>

<table class='printtable'>
	<tr>
<th>Дата обследования</th>
<th>№ кабинета</th>
<th>Наименование оборудования</th>
<th>Дата ввода в эксплуатацию</th>
<th>Количество выполненных исследований</th>
<th>Наименование исследования</th>
<th>Ф.И.О. пациента</th>
<th>Диагноз при направлении</th>
<th>Дата рождения пациента</th>
<th>Ф.И.О. направившего подразделения</th>
<th>Заключение врача</th>
<th>Э.Э.Д.</th>			
<th>Количество дней простоя</th>
<th>Причина простоя</th>
<th>Принятые меры</th>
	</tr>
<?php 
//$dataProvider->itemCount=$dataProvider->getItemCount();

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_planview',
)); ?>
</table>
</div>