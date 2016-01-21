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
	array('label'=>'Местные Задачи', 'url'=>'#','visible'=>(Yii::app()->user->checkAccess('inGroup',array('it'))),'linkOptions'=>array('class'=>'done','onclick'=>'sameTasks('.$model->id.',"cab")')),
	array('label'=>'Лог', 'url'=>'#','visible'=>(Yii::app()->user->checkAccess('inGroup',array('it'))),'linkOptions'=>array('class'=>'showlogUni','id'=>$model->id,'mod'=>get_class($model)),)
);
}

$this->renderPartial('/workplace/storages');


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

			$this->renderPartial('/workplace/_divview',array('wp'=>$wp),false,false);
		}
	}
	
?>
	
