<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */

$this->breadcrumbs=array(
	($model->idCabinet->idFloor->idBuilding->bname)=>array("/building/".$model->idCabinet->idFloor->idBuilding->id),
	($model->idCabinet->cname.' '.$model->idCabinet->num)=>array("/cabinet/".$model->idCabinet->id),
	$model->wname,
);

if(Yii::app()->user->checkAccess('moderator')){
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
}
?>

<h1><?php  echo $model->wname?></h1> 

<?php $ruleWP=Yii::app()->user->checkAccess('ruleWorkplaces'); ?>
<?php if($ruleWP):?>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/create?Equipment[id_workplace]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить оборудование</div>
</a>

<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/createPack?Equipment[id_workplace]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить набор</div>
</a>
<?php endif; ?>

<?php /* $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
array(               
            	'label'=>'Кабинет',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode($model->idCabinet->cname),
                array('Cabinet/view','id'=>$model->idCabinet->id)),
        ),array(               
            	'label'=>'Сотрудник',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode($model->idPersonnel->surname),
                array('Personnel/view','id'=>$model->idPersonnel->id)),
        ),		'wname',
	),
)); */?> 

<div style="clear: both"></div>
<dl>
  <dt>Кабинет</dt>
   <dd><?php echo ($model->idCabinet->cname.' '.$model->idCabinet->num) ?></dd>
  <dt>Сотрудник</dt>
   <dd><?php 
   	if(!empty($model->idPersonnel)){
   		echo ($model->idPersonnel->surname.' '.$model->idPersonnel->name.' '.$model->idPersonnel->patr);		
   	}else{
   		echo '-//-';
   	}
   	?>
    </dd>
</dl>
	
	<?php
	  if(!empty($model->equipments)) 
		$this->renderPartial('/equipment/tableview',array('equipments'=>$model->equipments),false,false); 
	?>
    







