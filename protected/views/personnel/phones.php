<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Телефонный справочник',
);
if (Yii::app()->user->name=='admin'){
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
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

<p><span style="font-size: 20pt;">Телефонный справочник</span>

<?php echo CHtml::link($searcimg,'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:block">
<?php $this->renderPartial('_uni_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
</p>


<table class='phonetable' style="table-layout: auto" >
	<tr>
		<th>Телефон</th><th>ФИО/Кабинет</th><th>Подробности</th>
	</tr>
<?php 
//$dataProvider->itemCount=$dataProvider->getItemCount();

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search_pers_phones(),
	'itemView'=>'_phoneview',
)); ?>
</table>
