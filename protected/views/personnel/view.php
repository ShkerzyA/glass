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
	<div class="avatar"> <div><img src="<?php echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($model->photo)); ?>"></div> </div>
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

	echo'<div><b>'.CHtml::encode($model->surname).' '.CHtml::encode($model->name).' '.CHtml::encode($model->patr).'</b> (тел.'.($ph=(!empty($model->workplaces))?CHtml::encode($model->workplaces->idCabinet->phone):'').')</div>';
	echo'<div><b>Дата рождения: '.CHtml::encode($birthday).' (Пол: '.CHtml::encode($sex).')</div>';
	if (!empty($model->workplaces->idCabinet)){
		echo'<div>Кабинет: "'.CHtml::encode($model->workplaces->idCabinet->cname).' №'.CHtml::encode($model->workplaces->idCabinet->num).'" '.CHtml::encode($model->workplaces->idCabinet->idFloor->fname).' '.CHtml::encode($model->workplaces->idCabinet->idFloor->idBuilding->bname).'</div>';
	}
	echo"<br><div><h3>Занимаемые должности:</h3>";
	foreach($model->personnelPostsHistories as $posts){
		$date_end=CHtml::encode($posts->date_end);
		$date_end=(!empty($date_end))?'  по '.$date_end:'';
		if ($posts->inactive())
					echo '<span style="text-decoration: line-through">';
				else
					echo '<span>';
		echo'<div>'.CHtml::encode($posts->idPost->idDepartment->name).'/'.($ps=(!empty($posts->idPost))?CHtml::encode($posts->idPost->post):'').' <nobr>(c '.CHtml::encode($posts->date_begin).$date_end.')</nobr></div>';
	echo "</span>";
	}
	echo '</div>';

	echo"<br><div><h3>Оснащение рабочего места:</h3>";
	if(!empty($model->workplaces->equipments)){
		foreach($model->workplaces->equipments as $equipments){
			echo'<div>'.CHtml::encode($equipments->ename).' (С/Н: '.CHtml::encode($equipments->serial).')</nobr></div>';
		}	
	}
	echo '</div>';
	?>
</div>






