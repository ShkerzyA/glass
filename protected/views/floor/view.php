<?php
/* @var $this FloorController */
/* @var $model Floor */

$this->breadcrumbs=array(
	'КККОД'=>array('/myAdmin/index'),
	$model->idBuilding->bname=>array('/Building/'.$model->idBuilding->id),
	$model->fname.' '.$model->fnum,
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

<?php if($ruleWP):?>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/cabinet/create?Cabinet[id_floor]=<?php echo $model->id ?>">
	<div id="add_task" class="add_unit fl_right">добавить кабинет</div>
</a>
<?php endif; ?>

<h1><?php echo $model->fname.' '.$model->fnum; ?></h1> </a>

	<?php 

		if(!empty($model->cabinets)){
			$this->renderPartial('/cabinet/compactview',array('cabinets'=>$model->cabinets),false,false);
		}

	?>

