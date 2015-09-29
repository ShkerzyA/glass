<?php
/* @var $this TasksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$model::$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>


<?php 

$this->renderPartial('grid',array(),false,false);
/*

print_r(Yii::app()->user->groups);

foreach ($models as $v) {
	echo $v->name;
	foreach ($v->Tasks as $t) {
		echo $t->tname;
		# code...
	} 
	# code...
}*/
?>
