<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('helpDesk?id_department='.$model->id_department.'&&group='.$model->group),
	$model->id,
);

Yii::app()->clientScript->registerPackage('actions');
if(Yii::app()->user->role=='administrator'){
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);}


	$status_arr=$model->getStatus();
	$status=$model->gimmeStatus();
	if(Yii::app()->user->checkAccess('saveStatus',array('mod'=>$model))){
		echo(CHtml::dropDownList('status',$model->status,$status_arr,array('class'=>$status['css_class']))); 
	}

?>

<?php 
if(Yii::app()->user->checkAccess('saveMessage',array('mod'=>$model))){
	echo ActionHelper::message();
}
	echo ActionHelper::info($model);
?>

<?php

echo '<div class="comment " id="taskbody">
		<div style="position: relative; float: left;"><h2>'.$model->tname.'</h2></div>
		<div style="position: relative; float: right; text-align: right"><i>'.$model->timestamp.'<br>
		Создатель:  '.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div>'.
		'<hr><p class="norm_text"><pre>'.$model->ttext.'</pre></p>
		<span style="float: right">Сопричастные: ';
		$tmp=explode(',',$model->executors); 
		$exec=array();
				foreach ($tmp as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->surname.' '.$pers->name);
					}
				}	
				echo (implode(', ', $exec));
		echo '</span></div> ';


		foreach ($model->TasksActions as $action){
			echo'<div class="comment">';
			
			echo'<div class="comment-topline"><i>'.$action->creator0->surname.' '.$action->creator0->name.' '.$action->creator0->patr.'</i> &nbsp;&nbsp;&nbsp; '.$action->timestamp.'</div>';
			echo'<div class="sign"></div>';

			echo'<div style="position: relative; float: left; height: 60px; margin: 5px;"> <img height=100% src="';
			if (!empty($action->creator0->photo)){
				echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($action->creator0->photo)); 
			}else{
				echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
			}
			echo'"></div>';

			if($action->type==0){
				echo '<b>"'.$status_arr[$action->ttext].'"</b> Статус задачи изменен';
			}else{
				echo '<pre style="overflov: none;">'.$action->ttext.'</pre>';	
			}
			echo'</div>';
		}


?>


