<?php
/* @var $this TasksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$modelLabelP,
);

$this->menu=array(
	array('label'=>'К текущим задачам', 'url'=>array('helpdesk')),
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

?>
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<div style="clear: both"></div>
<br>

<h1><?php  echo $modelLabelP; ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'taskpanel',
	'sortableAttributes'=>array(
        'tname',
        'timestamp',
    ),
)); ?>
