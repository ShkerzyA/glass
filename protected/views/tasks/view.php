<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('helpDesk?group='.(implode(',',$model->Project0->group))),
	$model->id,
);

Yii::app()->clientScript->registerPackage('actions');
$this->menu=array(
	array('label'=>'Присоединиться', 'url'=>array('join', 'id'=>$model->id),'linkOptions'=>array('class'=>'add_mark'),'visible'=>True),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('updateTs',array('mod'=>$model))),
	array('label'=>'Удалить', 'url'=>'#','visible'=>Yii::app()->user->role=='administrator', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>Yii::app()->user->role=='administrator'),
);


	$status_arr=$model->getStatus();
	$status=$model->status0;
	if(Yii::app()->user->checkAccess('saveStatus',array('mod'=>$model))){
		echo(CHtml::dropDownList('status',$model->status,$status_arr,array('class'=>$status['css_class']))); 
	}

?>

<?php 

if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$model))){
	$this->renderPartial('/actions/report_message', array('model'=>$model), false, false);
}
if(Yii::app()->user->checkAccess('saveMessage',array('mod'=>$model))){
	$this->renderPartial('/actions/message', array(), false, false);
}
	$this->renderPartial('/actions/info', array('model'=>$model), false, false); 
?>

<div style="position: relative; clear: both;"></div>

<?php

echo '<div class="comment " id="taskbody">
		<div style="position: relative; float: left;"><h2>'.$model->tname.'</h2></div>
		<div style="position: relative; float: right; text-align: right"><i>'.$model->timestamp.'<br>
		Создатель:  '.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div>'.
		'<hr><p class="norm_text"><pre>'.$model->detailsShow(0,1,1).'<br>'.$model->ttext.'</pre></p>
		<span style="float: right">Участники: ';
		$exec=array();
				foreach ($model->executors as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->fio());
					}
				}	
				echo (implode(', ', $exec));
		echo '</span></div> ';


		$isRep=Yii::app()->user->checkAccess('taskReport',array('mod'=>$model));

		foreach ($model->TasksActions as $action){
			
		

			switch ($action->type) {
				case '0':
					$mess='<b>"'.$status_arr[$action->ttext].'"</b> Статус задачи изменен';
					break;
				case '2':
					if($isRep){
						$rep=explode('\/',$action->ttext);
						$del=($action->creator==Yii::app()->user->id_pers)?'<div class="delete_this del_taskact" id='.$action->id.' style="float: right; z-index: 59; "></div>':'';

						$mess=$del.'<h3 style="text-align: right; margin: 2px;">Отчет по задаче</h3>'.$rep[0].' ('.$rep[2].') <br>'.$rep[1].' ';
					}else{
						$mess=NULL;
					}
					break;
				case '1':
				default:
					$mess='<pre style="overflov: none;">'.$action->ttext.'</pre>';	
					break;
			}

			if(empty($mess)){
				continue;
			}
			echo'<div class="comment" id='.$action->id.'>';
			echo'<div class="comment-topline"><i>'.$action->creator0->fio_full().'</i> &nbsp;&nbsp;&nbsp; '.$action->timestamp.'</div>';
			echo'<div class="sign"></div>';

			echo'<div style="position: relative; float: left; height: 60px; margin: 5px;"> <img height=100% src="';
			if (!empty($action->creator0->photo)){
				echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($action->creator0->photo)); 
			}else{
				echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
			}
			echo'"></div>';
		
			echo $mess;

			echo'</div>';
		}


?>


