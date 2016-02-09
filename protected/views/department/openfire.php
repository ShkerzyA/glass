<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Отделы'=>array('tree'),
	$model->name,
);



?>

<h1><?php echo $model->name; ?></h1> <a href=<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[id_department]=<?php echo $model->id ?>><div class="add_unit fl_right" id="add_task">добавить заявку</div></a>

<table id="personTbl" align=center>

<?php
	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($model->departmentPosts)){
		foreach($model->departmentPosts as $dp){
			if(!empty($dp->personnelPostsHistories)){
				foreach($dp->personnelPostsHistories as $personnelPh){
					
					echo "<tr><td>".$personnelPh->idPersonnel->wrapFio('fio_full')."</td><td>логин: ".mb_strtolower($personnelPh->idPersonnel->fioRu2Lat())."</td><td>пароль: ".$personnelPh->idPersonnel->passGen()."</td></tr>";
				}
			}
		}
	}
?>
</table>

