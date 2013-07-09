<?php
/* @var $this PersonnelPostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Personnel Posts',
);

$this->menu=array(
	array('label'=>'Create PersonnelPosts', 'url'=>array('create')),
	array('label'=>'Manage PersonnelPosts', 'url'=>array('admin')),
);
?>

<h1>Personnel Posts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
