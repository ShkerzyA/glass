<?php
/* @var $this WorkplaceController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>


<?php 
	$i=0;
	foreach ($models as $wp) {
		$i++;
		$this->renderPartial('_cabdivview',array('wp'=>$wp,'i'=>$i));
	}
?>
