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


	echo'<div><b>'.CHtml::encode($model->surname).' '.CHtml::encode($model->name).' '.CHtml::encode($model->patr).'</b> (тел.'.($ph=(!empty($model->Cabinet))?CHtml::encode($model->Cabinet->phone):'').')</div>';
	if (!empty($model->Cabinet)){
		echo'<div>Кабинет: "'.CHtml::encode($model->Cabinet->name).' №'.CHtml::encode($model->Cabinet->num).'" '.CHtml::encode($model->Cabinet->building->name).' '.CHtml::encode($model->Cabinet->floor).'эт. </div>';
	}
	echo"<br><div><h3>Занимаемые должности:</h3>";
	foreach($model->PostsHistory as $posts){
		$date_end=CHtml::encode($posts->date_end);
		$date_end=(!empty($date_end))?$date_end:'по наст. время';
		echo'<div>'.CHtml::encode($posts->department_posts->department->name).'('.($ps=(!empty($posts->department_posts))?CHtml::encode($posts->department_posts->post):'').') ('.CHtml::encode($posts->date_begin).'-'.$date_end.')</div>';
	}
	echo '</div>';
	?>
</div>






