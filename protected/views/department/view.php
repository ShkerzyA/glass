<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Отделы'=>array('tree'),
	$model->name,
);


$this->menu=array(
	array('label'=>'Актуально', 'url'=>array('','id'=>$model->id,'showH'=>0)),
	array('label'=>'История', 'url'=>array('','id'=>$model->id,'showH'=>1)),
	array('label'=>'Openfire', 'url'=>array('openfire','id'=>$model->id),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1><?php echo $model->name; ?></h1> <a href=<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[id_department]=<?php echo $model->id ?>><div class="add_unit fl_right" id="add_task">добавить заявку</div></a>

<table id="personTbl" align=center>

	<tr>
		<th>Штатная структура:</th>
		<th>Сотрудники:</th>
<?php
	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($model->departmentPosts)){
		foreach($model->departmentPosts as $dp){
			echo "<tr><td class='postList'>";
			if (!empty($dp->islead))
				echo '<b>';
			if ($dp->inactive())
					echo '<span style="text-decoration: line-through">';
				else
					echo '<span>';
			echo $dp->post_rn.'/'.$dp->post." (".$dp->rate.")</span></b></td><td class='persList'>";
			echo'<table class="zebra">';
			if(!empty($dp->personnelPostsHistories)){
			foreach($dp->personnelPostsHistories as $personnelPh){

				echo'<tr><td>';
				if ($personnelPh->inactive())
					echo '<span style="text-decoration: line-through">';
				else
					echo '<span>';
				echo "<a href='".Yii::app()->request->baseUrl."/personnel/".$personnelPh->idPersonnel->id."'>".$personnelPh->idPersonnel->surname.' '.$personnelPh->idPersonnel->name.' '.$personnelPh->idPersonnel->patr."</a> <br>";
				//echo "<br>логин: ".mb_strtolower($personnelPh->idPersonnel->fioRu2Lat())."<br>пароль: ".$personnelPh->idPersonnel->passGen()."<br> <a href=".Yii::app()->baseUrl."/Personnel/inOpenFire?id=".$personnelPh->idPersonnel->id." target=_blank>регистрация в Openfire</a><br>";
				echo "(c ".$personnelPh->date_begin.($de=(!empty($personnelPh->date_end))?(" по ".$personnelPh->date_end):'').")";
				if($personnelPh->is_main==1){
					echo ' основная';
				}else{
					echo ' совместительство';
				}
				echo"</td>";
				echo'<td>';
				foreach ($personnelPh->idPersonnel->zempleavs as $vacation) {
					echo 'c '.$vacation->startdate.' по '.$vacation->enddate.'';
				}
				echo'</td></tr>';
			}
			}else{
				echo '-//-';
			}
			echo'</table>';

			echo "</span></td>";
			echo "<td>";
			echo "</td></tr>";
		}
	}
?>
	</tr>
</table>

