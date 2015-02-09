<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

$this->breadcrumbs=array(
	'КККОД'=>array('/myAdmin/index'),
	$model->idFloor->idBuilding->bname=>array('/building/view/'.$model->idFloor->idBuilding->id),
	$model->idFloor->fname=>array('/floor/view/'.$model->idFloor->id),
	$model->cname,
);

if(Yii::app()->user->checkAccess('moderator')){
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
}
?>
<?php $ruleWP=Yii::app()->user->checkAccess('ruleWorkplaces'); ?>

<h3 algn=center><?php echo $model->idFloor->idBuilding->bname.'/'.$model->idFloor->fname.'<br>'.$model->cname.' каб. №'.$model->num.' (телефон: '.$model->phone.')'; ?></h3>

<?php if($ruleWP):?>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/workplace/create?Workplace[id_cabinet]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить рабочее место</div>
</a>


<?php endif; ?>



<div style="clear: both"></div>
<?php
	//print_r($DepPosts[1]->personnelsPh[0]->personnel);
	if(!empty($model->workplaces)){
		
		foreach($model->workplaces as $wp){

			$phone=(!empty($wp->phone))?'(тел. '.$wp->phone.')':'';
			echo'<a href="'.Yii::app()->request->baseUrl.'/Workplace/'.$wp->id.'"><div class="hipanel open">';
			if(!empty($wp->idPersonnel)){
				echo '<h4>'.$wp->idPersonnel->surname.' '.$wp->idPersonnel->name.' '.$wp->idPersonnel->patr.' '.$phone.'</h4>';	
			}else{
				echo '<h4>'.$wp->wname.'  '.$phone.'</h4>';
			}

			if(!empty($wp->equipments)){
				switch ($wp->type) {
					case '1':
						$this->renderPartial('/equipment/storagetableview',array('equipments'=>$wp->eqCount()),false,false); 
						break;
					
					default:
						$this->renderPartial('/equipment/compactview',array('equipments'=>$wp->equipments),false,false); 
						break;
				}
			}

		echo "</div></a>";
		}
	}
	
?>
	
