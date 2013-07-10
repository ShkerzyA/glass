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

<h1><?php echo $model->name; ?></h1>

<table id="personTbl">

	<tr>
		<td colspan=3 id="right">Сотрудники отдела:</td>
<?php
	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($DepPosts)){
		foreach($DepPosts as $dp){
			echo "<tr><td></td><td>".$dp->post."</td><td>";
			foreach($dp->personnelPostsHistories as $personnelPh){
				echo "<a href='/glass/personnel/".$personnelPh->idPersonnel->id."'>".$personnelPh->idPersonnel->surname.' '.$personnelPh->idPersonnel->name.' '.$personnelPh->idPersonnel->patr."</a><br>";
		
			}
			echo "</td></tr>";
		}
	}
?>
	</tr>
</table>

