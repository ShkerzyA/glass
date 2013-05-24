<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */

$this->breadcrumbs=array(
	'Personnel Posts Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PersonnelPostsHistory', 'url'=>array('index')),
	array('label'=>'Create PersonnelPostsHistory', 'url'=>array('create')),
	array('label'=>'View PersonnelPostsHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PersonnelPostsHistory', 'url'=>array('admin')),
);
?>

<h1>Update PersonnelPostsHistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>