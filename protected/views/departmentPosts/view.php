<?php
/* @var $this DepartmentPostsController */
/* @var $model DepartmentPosts */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Отобразить "<?php  echo $model::$modelLabelS; ?>"  #<?php echo $model->id; ?></h1> 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'post',
		'date_begin',
		'date_end',
		'islead',
		'kod_parus',
array(               
            	'label'=>'Department',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode($model->postSubdivRn->name),
                array('Department/view','id'=>$model->postSubdivRn->id)),
        ),	),
)); ?>
