<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Отделы'=>array('tree'),
	$model->name,
);

/*
$this->menu=array(
	array('label'=>'List Department', 'url'=>array('index')),
	array('label'=>'Create Department', 'url'=>array('create')),
	array('label'=>'Update Department', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Department', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Department', 'url'=>array('admin')),
);*/
?>

<h1><?php echo $model->name; ?></h1> <div class="add_unit fl_right" id="add_task">добавить задание</div>

<table id="personTbl" align=center>

	<tr>
		<td>Штатная структура:</td>
		<td>Сотрудники:</td>
<?php
	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($DepPosts)){
		foreach($DepPosts as $dp){
			echo "<tr><td class='persList'>";
			if (!empty($dp->islead))
				echo '<b>';
			echo $dp->post."</b></td><td class='persList'>";
			if(!empty($dp->personnelPostsHistories)){
			foreach($dp->personnelPostsHistories as $personnelPh){

				if ($personnelPh->inactive())
					echo '<span style="text-decoration: line-through">';
				else
					echo '<span>';
				echo "<a href='".Yii::app()->request->baseUrl."/personnel/".$personnelPh->idPersonnel->id."'>".$personnelPh->idPersonnel->surname.' '.$personnelPh->idPersonnel->name.' '.$personnelPh->idPersonnel->patr."</a><br>";
				echo "(c ".$personnelPh->date_begin.($de=(!empty($personnelPh->date_end))?(" по ".$personnelPh->date_end):'').")";
				if($personnelPh->is_main==1){
					echo ' основная';
				}else{
					echo ' совместительство';
				}

				echo"<br>";
			}
			}else{
				echo '-//-';
			}

			echo "</span></td></tr>";
		}
	}
?>
	</tr>
</table>

