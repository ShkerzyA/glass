<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Personnel Posts Histories',
);

$this->menu=array(
	array('label'=>'Create PersonnelPostsHistory', 'url'=>array('create')),
	array('label'=>'Manage PersonnelPostsHistory', 'url'=>array('admin')),
);
?>

<h1>Personnel Posts Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
