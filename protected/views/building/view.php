<?php
/* @var $this BuildingController */
/* @var $model Building */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
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
		echo '<div>'.$floor->fname;
		if(!empty($floor->cabinets))
			foreach ($floor->cabinets as $cabinet) {
				echo '<a href='.Yii::app()->homeUrl.'Cabinet/'.$cabinet->id.'><div>'.$cabinet->cname.' каб. №'.$cabinet->num.'</div></a>';
			}
		echo'</div>';
	}

?>
</div>


