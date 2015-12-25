<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кадры',
);
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление кадрами', 'url'=>array('admin'),'visible'=>Yii::app()->user->role=='administrator'),
	array('label'=>'Тиль', 'url'=>array('tiles'),'visible'=>Yii::app()->user->checkAccess('moderator')),
	array('label'=>'Дни рождения', 'url'=>array('birthdays'),'visible'=>Yii::app()->user->checkAccess('moderator')),
);

$months=array('','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');

?>

<p><span style="font-size: 20pt;">Кадры. Дни рождения</span>
</p>

<?php 
$date='';
foreach ($models as $v) {
	$dO=new DateTime($v->birthday.' 00:00:00');
	$md=$months[$dO->format('m')].' '.$dO->format('d');
	if($md!=$date){
		$date=$md;
		echo '<h2>'.$date.'</h2>';
	}
	$this->renderPartial('_bdview',array('model'=>$v));
}
 ?>
