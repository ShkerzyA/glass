<?php
/* @var $this BuildingController */
/* @var $model Building */

$this->breadcrumbs=array(
	'КККОД'=>array('/myAdmin/index'),
	$model->bname,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h3><?php  echo $model->bname.' ('.$model->adress.')';?></h3> 

<div class="hierarchy">
<?php
if (!empty ($model->floors))
	foreach ($model->floors as $floor) {
		echo '<div class="hipanel done">'.$floor->fname;
		if(!empty($floor->cabinets))
			$this->renderPartial('/cabinet/compactview',array('cabinets'=>$floor->cabinets),false,false);
		echo'</div>';
	}

?>
</div>


