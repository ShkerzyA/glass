<?php
/* @var $this CallLogController */
/* @var $dataProvider CActiveDataProvider */

switch (get_class($model)) {
	case 'CallLogApus':
		$pfx='Apus';
		break;

	case 'CallLogAuto':
		$pfx='';
		break;
	
	default:
		$pfx='';
		break;
}


$this->breadcrumbs=array(
	''.$model::$modelLabelP,
);

$this->menu=array(
	array('label'=>'Лог Звонков Автоматика', 'url'=>array('/callLog')), 
	array('label'=>'Лог Звонков АПУС', 'url'=>array('/callLog/indexApus')), 
	array('label'=>'Лог Звонков/импорт', 'url'=>array('/callLog/import')), 
);
?>

<a target="_blank" href="/glass/callLog/export<?php echo $pfx?>?<?php echo $_SERVER["QUERY_STRING"] ?>">
		<div id="add_task" class="add_unit fl_right" style="float: right; width: 200px">Экспорт текущей выборки</div>
	</a>
<h1><?php  echo $model::$modelLabelP; ?></h1>

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
<?php $this->renderPartial('_search'.$pfx,array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<table class="logtable">
	<?php $this->renderPartial('_th'.$pfx); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view'.$pfx,
)); ?>
</table>
