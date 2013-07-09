<?php
/* @var $this PersonnelPostsController */
/* @var $model PersonnelPosts */

$this->breadcrumbs=array(
	'Personnel Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PersonnelPosts', 'url'=>array('index')),
	array('label'=>'Manage PersonnelPosts', 'url'=>array('admin')),
);
?>

<h1>Create PersonnelPosts</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>