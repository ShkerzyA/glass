<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Кадры'=>array('index'),
	$model->surname.' '.$model->name,
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
	<?php if(!empty($model->photo)): ?>
		<div class="avatar"> <div><img src="<?php echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($model->photo)); ?>"></div> </div>
	<?php else: ?>
		<div class="avatar"> <div><img src="<?php echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg'); ?>"></div> </div>
	<?php endif; ?>


</div>
<div id="dataPersonnel">
	<?php 

	if($model->sex===0){
		$sex='Мужской';
	}else if($model->sex===1){
		$sex='Женский';
	}else
	{
		$sex='Не указан';
	}

	$birthday=(!empty($model->birthday))?date('d.m.Y',strtotime($model->birthday)):'-//-';

	echo'<div><b>'.CHtml::encode($model->fio_full()).'</b> ';
	$phone=$model->allPhones();
	if(!empty($phone['cab'] or $phone['pers']))
	echo '<br> Тел: (каб. '.implode(',',$phone['cab']).' личн. '.implode(',',$phone['pers']).')';
	echo'</div>';
	echo'<div><b>Дата рождения: '.CHtml::encode($birthday).' (Пол: '.CHtml::encode($sex).')</b></div>';
	if (Yii::app()->user->role=='administrator')
		echo '<div>Пароль для jabber: <b>'.$model->passGen().'</b> <a href='.Yii::app()->baseUrl.'/Personnel/inOpenFire?id='.$model->id.' target=_blank>регистрация в Openfire</a></div>';
	echo"<br><div><h3>Занимаемые должности:</h3>";
	foreach($model->personnelPostsHistories as $posts){
		$date_end=CHtml::encode($posts->date_end);
		$date_end=(!empty($date_end))?'  по '.$date_end:'';
		if ($posts->inactive())
					echo '<span style="text-decoration: line-through">';
				else
					echo '<span>';
		echo'<div>'.($ps=(!empty($posts->idPost))?CHtml::encode($posts->idPost->postSubdivRn->name.'/'.$posts->idPost->post):'').' <nobr>(c '.CHtml::encode($posts->date_begin).$date_end.')</nobr></div>';
	echo "</span>";
	}
	echo '</div>';
	?>
</div>
	<div style="clear: both;"></div>
	<?php
		foreach ($model->workplaces as $wp) {
			if (!empty($wp->idCabinet)){
				echo'<div>Кабинет: <a href="/glass/Cabinet/'.$wp->idCabinet->id.'"">"'.CHtml::encode($wp->idCabinet->cname).' каб. №'.CHtml::encode($wp->idCabinet->num).'" '.CHtml::encode($wp->idCabinet->idFloor->fname).' '.CHtml::encode($wp->idCabinet->idFloor->idBuilding->bname).'</a></div>';
			}
			if(!empty($wp->equipments)) 
				$this->renderPartial('/equipment/tableview',array('equipments'=>$wp->equipments)); 
		}
	?>





