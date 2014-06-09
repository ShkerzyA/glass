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

<h1><?php echo $model->fname.' '.$model->fnum; ?></h1> 

	<?php 

		if(!empty($model->cabinets)){
			$this->renderPartial('/cabinet/compactview',array('cabinets'=>$model->cabinets),false,false);
		}

	?>

