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
		<td id="right">Руководитель отдела:</td>
		<td>
<?php
if(!empty($model->managerDep)){
	$managerId=$model->managerDep->id;
	echo "<a href='/glass/personnel/".$model->managerDep->id."'>".$model->managerDep->surname." ".$model->managerDep->name." ".$model->managerDep->patr."</a>";
}else{
	$managerId=0;
}
?>
		</td>
	</tr>
	<tr>
		<td id="right">Сотрудники отдела:</td>
		<td>
<?php

	

	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($DepPosts)){
		foreach($DepPosts as $dp){
			foreach($dp->personnel_posts_history as $personnelPh){
				if ($personnelPh->personnel->id!=$managerId)
				echo "<a href='/glass/personnel/".$personnelPh->personnel->id."'>".$personnelPh->personnel->surname.' '.$personnelPh->personnel->name.' '.$personnelPh->personnel->patr."</a><br>";
		
			}
		}
	}
?>
		</td>
	</tr>
</table>

