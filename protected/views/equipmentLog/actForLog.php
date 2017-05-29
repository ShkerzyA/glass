<?php
/* @var $this EquipmentLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1><?php  echo $modelLabelP; ?></h1>
<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#list-view').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$searcimg='<img align=right src='.(Yii::app()->request->baseUrl.'/images/magnifier_32.png').'>';

?>

<?php echo CHtml::link($searcimg,'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:block">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>

</div><!-- search-form -->
<?php echo CHtml::beginForm('/glass/actOfTransfer/create','post'); ?>
<?php echo CHtml::submitButton('Создать акт перемещения для выделенного оборудования',array('style'=>'width: 400px; float: right;')); ?>
<div class=clear></div>
<table class="logtable">
	<tr>
		<th>Дата</th>
		<th>Субъект</th>
		<th>Объект</th>
		<th>Действие</th>
		<th>Детали</th>
		<th>Добавить в акт</th>
	</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->searchForAct(),
	'itemView'=>'_view_for_act',
)); ?>
</table>
<?php echo CHtml::endForm(); ?>