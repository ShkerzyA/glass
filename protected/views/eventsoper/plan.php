<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#eventsoper-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<input name="print" class="hide_p" type="button" style="float: right; width: 100px"value="Печать" onclick="window.print();"> 
<div style="margin: 3px">
<?php echo CHtml::link('','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:block">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); 

$tpl=array(	'0,1,2'=>array('app'=>'Приложение 1','title'=>'План работы операционных'),
			'3'=>array('app'=>'Приложение 2','title'=>'Мониторинг работы операционных'));




?>
</div><!-- search-form -->
	<p style="text-align: right"><?php echo $tpl[$model->status]['app']?></p>
<h2 style="text-align: center; margin: 0px;"><?php echo $tpl[$model->status]['title']?></h2>

<table class='printtable'>
	<tr>
		<th>№ операционной</th>
		<th>Дата</th>
		<th>Время</th>
		<th>Ф.И.О. пациента</th>
		<th>Дата госпитализации</th>
		<th>Оператор</th>
		<th>Операционная сестра</th>
		<th>Анестезиологи</th>
		<th>Бригада</th>
		<th>Операция</th>
		<th>Тип операции</th>
	</tr>
<?php 
//$dataProvider->itemCount=$dataProvider->getItemCount();

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_planview',
)); ?>
</table>
</div>