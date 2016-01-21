<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */

$this->breadcrumbs=array(
  'КККОД'=>array('/myAdmin/index'),
	($model->idCabinet->idFloor->idBuilding->bname)=>array("/building/".$model->idCabinet->idFloor->idBuilding->id),
  ($model->idCabinet->idFloor->fname)=>array("/floor/".$model->idCabinet->idFloor->id),
	($model->idCabinet->cname.' '.$model->idCabinet->num)=>array("/cabinet/".$model->idCabinet->id),
	$model->wname,
);

if(Yii::app()->user->checkAccess('moderator')){
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	
);
}
if(Yii::app()->user->checkAccess('administrator')){
    $this->menu[]=array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
    $this->menu[]=array('label'=>'Управление', 'url'=>array('admin'));
}

if(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it')))){
      $this->menu[]=array('label'=>'Местные Задачи', 'url'=>'#','linkOptions'=>array('class'=>'done','onclick'=>'sameTasks('.$model->id.',"wp")'));
      $this->menu[]=array('label'=>'Лог', 'url'=>'#','visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it')))),'linkOptions'=>array('class'=>'showlogUni','id'=>$model->id,'mod'=>get_class($model)),);
}


$this->renderPartial('/workplace/storages');



?>

<h1><?php  echo $model->wname.' (тел. '.$model->phone.')';?></h1> 

<?php $ruleWP=Yii::app()->user->checkAccess('ruleWorkplaces'); ?>
<?php if($ruleWP):?>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/create?Equipment[id_workplace]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить оборудование</div>
</a>

<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/createPack?Equipment[id_workplace]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить набор</div>
</a>

<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/createPack?Equipment[id_workplace]=<?php echo $model->id ?>&&preset=HP">
  <div id="add_task" class="add_unit fl_right">добавить HP набор</div>
</a>

<a href="<?php echo(Yii::app()->request->baseUrl) ?>/equipment/createPack?Equipment[id_workplace]=<?php echo $model->id ?>&&preset=cart">
  <div id="add_task" class="add_unit fl_right">Картриджи</div>
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
   <dd><?php echo ($model->wpNameFull(1)) ?></dd>
  <dt>Рабочее место</dt>
   <dd><?php echo ($model->wpName());	?></dd>
  <dt>Отдел</dt>
   <dd><?php echo ($model->department()); ?></dd>
</dl>
<?php
	  if(!empty($model->equipments)){
      echo $info;
      $this->renderPartial('/equipment/tableview',array('model'=>$model),false,false);   
    } 
	?>

    







