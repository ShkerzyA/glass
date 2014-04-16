<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);


Yii::app()->clientScript->registerPackage('eventactions');
if(!(Yii::app()->user->isGuest)){
 	$id_pers=Yii::app()->user->id_pers;
}else{
	$id_pers=array();
}
	$this->menu=array(
		array('label'=>'Список', 'url'=>array('index'),'visible'=>(Yii::app()->user->role=='administrator')),
		array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
		array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>($model->creator==$id_pers)),
		array('label'=>'Удалить', 'url'=>'#','visible'=>(Yii::app()->user->role=='administrator'), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	);



	$status_arr=$model->getStatus();

	$status=$model->gimmeStatus();
	if(!(Yii::app()->user->isGuest)){
		if ($model->isChangeStatus()){
			echo(CHtml::dropDownList('status_task',$model->status,$status_arr,array('class'=>$status['css_class']))); 	
		}
	}
	
	
?>
<div class=modal_window_back style="display: none"></div>
<div id="add_task_act" class="add_unit fl_right">добавить сообщение</div>
<div style="border: 1px solid grey; position: absolute; margin-top: 40px; z-index: 88; display: none; background: #F0F0F0" class=modal_window>
	<div class=close_this style="align: right; "></div>
	<textarea style="width: 98%;" name="message" id="message" placeholder="сохранить комментарий: ctrl+enter"></textarea><br>
	<input type=button name="put_message" id="put_message" value="сохранить комментарий">
</div>
<div style="position: relative; clear: both;"></div>

<?php

echo '<div class="comment " id="taskbody">
		<div style="position: relative; float: left;"><h2>'.$model->name.'</h2></div>
		<div style="position: relative; float: right; text-align: right"><i>'.$model->date.' ('.$model->timestamp.'-'.$model->timestamp_end.')<br>
		Создатель:  '.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div>'.
		'<hr><p class="norm_text"><pre>'.$model->description.'</pre></p>
		</div> ';

		

		foreach ($model->EventsActions as $action){
			echo'<div class="comment">';
			echo'<div class="comment-topline"><i>'.$action->creator0->surname.' '.$action->creator0->name.' '.$action->creator0->patr.'</i> &nbsp;&nbsp;&nbsp; '.$action->timestamp.'</div>';
			echo'<div class="sign"></div>';
			if($action->type==0){
				echo '<b>"'.$status_arr[$action->ttext].'"</b> Статус события изменен';
			}else{
				echo '<pre style="overflov: none;">'.$action->ttext.'</pre>';	
			}
			echo'</div>';
		} 


?>


