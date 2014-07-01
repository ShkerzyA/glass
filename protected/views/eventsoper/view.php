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
		array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('updateEv',array('mod'=>$model)))),
		array('label'=>'Подтвердить без изменений', 'url'=>array('agree', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('updateEv',array('mod'=>$model)))),
		array('label'=>'Внести корректировки', 'url'=>array('monupdate', 'id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('updateEv',array('mod'=>$model)))),
		array('label'=>'Удалить', 'url'=>'#','visible'=>(Yii::app()->user->role=='administrator'), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	);
?>

<?php

echo '<div class="comment " id="taskbody">
		<div style="position: relative; float: left;"><h2>'.$model->operation0->name.'</h2></div>
		<div style="position: relative; float: right; text-align: right"><i>'.$model->date.' ('.$model->timestamp.'-'.$model->timestamp_end.')<br>
		Создатель:  '.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div>'.
		'<hr><p class="norm_text"><pre>'.$model->operation0->name.'</pre></p>';
		?>

		<dt><?php echo CHtml::encode($model->getAttributeLabel('operator')); ?> </dt> 
		<dd><?php
   		echo CHtml::encode($model->operator0->surname.' '.$model->operator0->name.' '.$model->operator0->patr); ?> </dd>

   		<dt><?php echo CHtml::encode($model->getAttributeLabel('anesthesiologist')); ?> </dt> 
		<dd><?php
   		echo CHtml::encode($model->anesthesiologist0->surname.' '.$model->anesthesiologist0->name.' '.$model->anesthesiologist0->patr); ?> </dd>


   		<dt><?php echo CHtml::encode($model->getAttributeLabel('brigade')); ?></dt> 
   		<dd><?php
   		$tmp=explode(',',$model->brigade); 
		$exec=array();
				foreach ($tmp as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->surname.' '.$pers->name);
					}
				}	
				echo (implode(', ', $exec)); ?></dd>

   	
<?php echo'</div>'; ?>
