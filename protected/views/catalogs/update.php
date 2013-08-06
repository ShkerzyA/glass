<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin')),
);
	$this->menu["details"]=array(array('label'=>'Docs', 'url'=>array('Docs/admin', 'id_catalog'=>$model->id)),
array('label'=>'Catalogs', 'url'=>array('Catalogs/admin', 'id_parent'=>$model->id)),
array('label'=>'Catalogs', 'url'=>array('Catalogs/admin', 'id_parent'=>$model->id)),
array('label'=>'DepartmentPosts', 'url'=>array('DepartmentPosts/admin', 'owner'=>$model->id)),
);
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>