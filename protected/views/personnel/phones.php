<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кадры',
);
if (Yii::app()->user->name=='admin'){
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление кадрами', 'url'=>array('admin')),
);
}

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
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
</p>


<table class='phonetable'>
	<tr>
		<th>Ф.И.О.</th><th>должность</th><th>отдел</th><th>кабинет</th><th>телефон</th>
	</tr>
<?php 
//$dataProvider->itemCount=$dataProvider->getItemCount();

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_phoneview',
)); ?>
</table>
