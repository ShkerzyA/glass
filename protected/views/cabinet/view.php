<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->cname,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>


<h3 algn=center><?php echo $model->idFloor->idBuilding->bname.'/'.$model->idFloor->fname.'<br>'.$model->cname.' каб. №'.$model->num.' (телефон: '.$model->phone.')'; ?></h3>

<table id="personTbl" align=center>

	<tr>
		<td>Сотрудник:</td>
		<td>Рабочее место:</td>
<?php
	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($model->workplaces)){
		foreach($model->workplaces as $wp){
			echo "<tr><td class='persList'>";
			echo $wp->idPersonnel->surname.' '.$wp->idPersonnel->name.' '.$wp->idPersonnel->patr;
			echo"</td><td class='persList'>";
			
			if(!empty($wp->equipments)){
				foreach($wp->equipments as $equipments){
					echo'<div>'.CHtml::encode($equipments->ename).' (С/Н:'.CHtml::encode($equipments->serial).')</nobr></div>';
				}	
			}else{
				echo '-//-';
			}
		}
		echo "</td></tr>";
	}
	
?>
	</tr>
</table>
