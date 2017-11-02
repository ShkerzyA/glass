<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

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
	$('#personnel-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Кадры</h1>

<?php echo CHtml::link('Поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'personnel-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'surname',
        'name',
        'patr',
        array( 'name'=>'idUserid_user', 'value'=>'$data->username()' ),
        'birthday',
        'date_begin',
        'date_end',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>