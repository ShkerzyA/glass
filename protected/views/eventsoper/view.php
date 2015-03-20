<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('rooms/show'), 
	$model->id,
);

 if(Yii::app()->session['Event_type']=='eventsOpMon'){
		$route='update/';
	}else{
		$route='';

	}



if(!(Yii::app()->user->isGuest)){
 	$id_pers=Yii::app()->user->id_pers;
}else{
	$id_pers=array();
}
	$this->menu=array(
		array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('operationsv'))) or (Yii::app()->user->checkAccess('inGroupAndOwner',array('group'=>'operations','mod'=>$model)) and $model->readyForEdit()) )),
		array('label'=>'Редак. анестезиологию', 'url'=>array('update', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('anestesiologist'))) and $model->readyForEdit())),
		array('label'=>'Утвердить план', 'url'=>array('confirm', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('operationsv'))) )),
		array('label'=>'Отменить утверждение', 'url'=>array('confirm', 'id'=>$model->id,'cansel'=>1),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('operationsv'))) )),
		array('label'=>'Подтвердить без изменений', 'url'=>array('agree', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('operations'))) and $model->readyForMon())),
		array('label'=>'Внести корректировки', 'url'=>array('monupdate', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>array('operations'))) and $model->readyForMon())),
		array('label'=>'Удалить', 'url'=>'#','visible'=>(Yii::app()->user->role=='administrator'), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	);
?>

<?php
$this->renderPartial('_viewone',array('model'=>$model,'typeEvent'=>'План'),false,false);
if(!empty($model->eventsopers)){
		$this->renderPartial('_viewone',array('model'=>$model->eventsopers,'typeEvent'=>'Мониторинг'),false,false);
	}
?>
