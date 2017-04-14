<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кадры',
);
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create'),'visible'=>Yii::app()->user->role=='administrator'),
	array('label'=>'Управление кадрами', 'url'=>array('admin'),'visible'=>Yii::app()->user->role=='administrator'),
	array('label'=>'Тиль', 'url'=>array('tiles'),'visible'=>Yii::app()->user->checkAccess('moderator')),
	array('label'=>'Дни рождения', 'url'=>array('birthdays'),'visible'=>Yii::app()->user->checkAccess('moderator')),
	array('label'=>'Отпуск', 'url'=>array('vacations'),'visible'=>Yii::app()->user->checkAccess('moderator')),
);

$months=array('','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');

?>

<p><span style="font-size: 20pt;">Кадры. Отпуска</span>
</p>


<table class='downline'>
<?php 
$today=date('d.m.Y');
$current_date='';
foreach ($models as $pers) {
	if($pers->zempleavs[0]->startdate != $current_date){
		$current_date=$pers->zempleavs[0]->startdate;
		$bg=($current_date==$today)?'red':'#ffddaa';
		echo '<tr style="background: '.$bg.';"><td colspan=3>'.$current_date.'</td></tr>';
	}
	echo '<tr><td></td><td>'.$pers->fio_full().'</td><td>';
	foreach ($pers->zempleavs as $vac) {
		echo''.$vac->startdate.'-'.$vac->enddate.'<br>';
		# code...
	}
	echo'</td></tr>';
}
 ?>
</table>
