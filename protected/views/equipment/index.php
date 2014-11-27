<?php
/* @var $this EquipmentController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerPackage('customfields');

$this->breadcrumbs=array(
	''.$modelLabelP,
);

$this->menu=array(
			
			array('label'=>'Оборудование/ Экспорт', 'url'=>array('/equipment/export'),'htmlOptions'=>array('target'=>'_blank')),
			array('label'=>'Картриджи/ Экспорт', 'url'=>array('/equipmentLog/exportCart'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>'it')))),
			array('label'=>'Заправка картриджей', 'url'=>array('/equipmentLog/Crefill?type=outgo')),
			array('label'=>'Возврат картриджей', 'url'=>array('/equipmentLog/Crefill?type=ingo')),
			);

$storage=Workplace::model()->with('idCabinet')->findAll(array('condition'=>'t.type=1'));



$this->menu['all_menu']=array(
		array('title'=>'Склады оборудования','items'=>array(
			)
		)
);

foreach ($storage as $v) {
	$this->menu['all_menu'][0]['items'][]=array('label'=>$v->wpNameFull(1).'/'.$v->wpName(), 'url'=>array('/Workplace/'.$v->id));
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
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<h1><?php  echo $modelLabelP; ?></h1>

<?php 
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
