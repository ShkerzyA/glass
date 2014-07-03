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
		array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('userOperationSV'))),
		array('label'=>'Подтвердить без изменений', 'url'=>array('agree', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('RoomOperationSV',array('mod'=>$model->idRoom)))),
		array('label'=>'Внести корректировки', 'url'=>array('monupdate', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('RoomOperationSV',array('mod'=>$model->idRoom)))),
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
