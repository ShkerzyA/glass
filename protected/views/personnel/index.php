<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кадры',
);
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление кадрами', 'url'=>array('admin'),'visible'=>Yii::app()->user->role=='administrator'),
	array('label'=>'Тиль', 'url'=>array('tiles'),'visible'=>Yii::app()->user->checkAccess('moderator')),
	array('label'=>'Дни рождения', 'url'=>array('birthdays')),
	array('label'=>'Отпуск', 'url'=>array('vacations'),'visible'=>Yii::app()->user->checkAccess('moderator')),
);

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

<p><span style="font-size: 20pt;">Кадры</span>

<?php echo CHtml::link($searcimg,'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:block">
<?php $this->renderPartial('_uni_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
</p>

<?php 
//$dataProvider->itemCount=$dataProvider->getItemCount();

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search_pers(),
	'itemView'=>'_indexview',
)); ?>
