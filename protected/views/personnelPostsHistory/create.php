<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */

$this->breadcrumbs=array(
	'Personnel Posts Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PersonnelPostsHistory', 'url'=>array('index')),
	array('label'=>'Manage PersonnelPostsHistory', 'url'=>array('admin')),
);
?>

<h1>Create PersonnelPostsHistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>