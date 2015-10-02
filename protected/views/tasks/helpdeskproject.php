<?php
/* @var $this TasksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$model::$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);

$week=array(0=>'<span style="color:red">Вс</span>',1=>'Пн',2=>'Вт',3=>'Ср',4=>'Чт',5=>'Пт',6=>'<span style="color:red">Сб</span>');

function tdEcho($num){
				for ($i=0; $i < $num; $i++) { 
					echo '<td></td>';
				}
			}
?>



<style>


.calendar{
	border-collapse: collapse;
}

.calendar, .calendar td, .calendar th{
	border-left : 1px solid #dadada; 
	border-right: 1px solid #dadada; 
	font-weight: normal;
	margin: 0px;
	padding: 0px;
}
.calendar th{
	border: 1px solid #dadada;
}
</style>
<div style="widht=100%; height: 100%;">
	<table class="calendar">
		<tr>
			<th colspan=3>
				Просрочено
			</th>
			<th rowspan=2 style="width: 50%;">
				Задание
			</th>
			<th colspan=11>
				Сегодня
			</th>
			<th colspan=7>
				Неделя
			</th>
			<th rowspan=2>
				Месяц
			</th>
		</tr>
		<tr>
			<th>От Недели</th>
			<th>До Недели</th>
			<th>День</th>

			<?php $cd=new DateTime() ;
				$wk=array('08','09','10','11','12','13','14','15','16','17','18');
				$h=$cd->format('H');
				foreach ($wk as $w) {
					$col=($h==$w)?'bold':'';
					echo "<th style='font-weight :$col;'>".$w."<sup>00</sup></th>";
				}
					# code..
			?>

			<?php $d=new DateTime();
			for ($x=1;$x<8;$x++){
				$d->modify('+1 days');
				echo '<th>'.$week[$d->format('w')].'</th>';
			}
			?>
		</tr>
		<?php $this->renderPartial('_helpdeskproject',array(
			'model'=>$model,'models'=>$models,
		)) ?>
	</table>
	<div class=cont style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 20;">
	</div>
</div>


