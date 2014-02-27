<?php
/* @var $this RoomsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);


$rooms_list=array();
foreach ($model as $v){
	$rooms_list[]=array('label'=>$v->idCabinet->cname, 'url'=>array('Rooms/show/'.$v->id));
}

$this->menu['all_menu']=array(
	array('title'=>'Помещения','items'=>$rooms_list),
)



?>

<h1><?php  echo $modelLabelP; ?></h1>


