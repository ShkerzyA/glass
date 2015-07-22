<?php
/* @var $this CallLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.CallLog::$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<a target="_blank" href="/glass/callLog/export?<?php echo $_SERVER["QUERY_STRING"] ?>">
		<div id="add_task" class="add_unit fl_right" style="float: right; width: 200px">Экспорт текущей выборки</div>
	</a>
<h1><?php  echo CallLog::$modelLabelP; ?></h1>

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
<table class="logtable">
	<tr>
		<th>Вызывающий номер</th>
		<th>Дата</th>
		<th>Код</th>
		<th>Направление</th>
		<th>Вызываемый номер</th>
		<th>Длительность</th>
		<th>Сумма</th>
	</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
</table>
