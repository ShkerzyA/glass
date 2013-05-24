<?php
/* @var $this PersonnelPostsController */
/* @var $model PersonnelPosts */

$this->breadcrumbs=array(
	'Personnel Posts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PersonnelPosts', 'url'=>array('index')),
	array('label'=>'Create PersonnelPosts', 'url'=>array('create')),
	array('label'=>'View PersonnelPosts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PersonnelPosts', 'url'=>array('admin')),
);
?>

<h1>Update PersonnelPosts <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>