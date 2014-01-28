<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

Yii::app()->clientScript->registerPackage('taskactions');
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
	echo(CHtml::dropDownList('status_task',$model->status,$status_arr,array('class'=>$status['css_class']))); 
?>
<div class=modal_window_back style="display: none"></div>
<div id="add_task_act" class="add_unit fl_right">добавить сообщение</div>
<div style="border: 1px solid grey; position: absolute; margin-top: 40px; z-index: 88; width: 95%; display: none; background: #F0F0F0" class=modal_window>
	<div class=close_this style="align: right; "></div>
	<textarea style="width: 98%;" name="message" id="message"></textarea><br>
	<input type=button name="put_message" id="put_message" value="сохранить комментарий">
</div>
<div style="position: relative; clear: both;"></div>

<?php
echo '<div style="border-radius: 3px; min-height: 46px; background: padding-left: 40px;">
		<div style="position: relative; float: left;"><h2>'.$model->tname.'</h2></div>
		<div style="position: relative; float: right; text-align: right"><i>'.$model->date_begin.'<br>
		'.$model->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$model->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$model->creator0->personnelPostsHistories[0]->idPersonnel->patr.'</i></div> '.
		'<hr><p class="norm_text">'.$model->ttext.'</p></div><hr>';


		foreach ($model->TasksActions as $action){
			echo'<div class="comment">';
			echo'<div class="comment-topline"><i>'.$action->creator0->surname.' '.$action->creator0->name.' '.$action->creator0->patr.'</i> &nbsp;&nbsp;&nbsp; '.$action->timestamp.'</div>';
			echo'<div class="sign"></div>';
			if($action->type==0){
				echo '<b>"'.$status_arr[$action->ttext].'"</b> Статус задачи изменен';
			}else{
				echo $action->ttext;	
			}
			echo'</div>';
		}


?>


