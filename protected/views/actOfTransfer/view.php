<?php
/* @var $this ActOfTransferController */
/* @var $model ActOfTransfer */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Экспорт в odt', 'url'=>array('export', 'id'=>$model->id),'htmlOptions'=>array('target'=>'_blank')),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Отобразить "<?php  echo $model::$modelLabelS; ?>"  #<?php echo $model->id; ?></h1> 

<dd>Создал: </dd><dt><?php echo $model->creator0->fio_full(); ?></dt>
<dd>Дата: </dd><dt><?php echo  $model->timestamp; ?></dt>
<dd>Статус: </dd><dt><?php echo $model->getStatus(); ?></dt>
<dd>Передал: </dd><dt><?php echo $model->getTransferring(); ?></dt>
<dd>Принял: </dd><dt><?php echo $model->getReceiving(); ?></dt>

<br>
<h3>Оборудование из акта</h3>
<?php
if(!empty($model->equipments)){
	$this->renderPartial('/equipment/simpleview',array('model'=>$model)); 
}

?>
