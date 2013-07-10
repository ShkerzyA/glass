<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Кадры'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Кадры', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->name=='admin')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>(Yii::app()->user->name=='admin')),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Удалить. Вы уверены?'),'visible'=>(Yii::app()->user->name=='admin')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->name=='admin')),
);
?>

<div id="avPersonnel">
	<div class="avatar"> <div><img src="<?php echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($model->photo)); ?>"></div> </div>
</div>
<div id="dataPersonnel">
	<?php 


	echo'<div><b>'.CHtml::encode($model->surname).' '.CHtml::encode($model->name).' '.CHtml::encode($model->patr).'</b> (тел.'.($ph=(!empty($model->workplaces))?CHtml::encode($model->workplaces->idCabinet->phone):'').')</div>';
	if (!empty($model->workplaces->idCabinet)){
		echo'<div>Кабинет: "'.CHtml::encode($model->workplaces->idCabinet->cname).' №'.CHtml::encode($model->workplaces->idCabinet->num).'" '.CHtml::encode($model->workplaces->idCabinet->idFloor->fname).' '.CHtml::encode($model->workplaces->idCabinet->idFloor->idBuilding->bname).'</div>';
	}
	echo"<br><div><h3>Занимаемые должности:</h3>";
	foreach($model->personnelPostsHistories as $posts){
		$date_end=CHtml::encode($posts->date_end);
		$date_end=(!empty($date_end))?'  по '.$date_end:'';
		echo'<div>'.CHtml::encode($posts->idPost->idDepartment->name).'/'.($ps=(!empty($posts->idPost))?CHtml::encode($posts->idPost->post):'').' <nobr>(c '.CHtml::encode($posts->date_begin).$date_end.')</nobr></div>';
	}
	echo '</div>';
	?>
</div>






