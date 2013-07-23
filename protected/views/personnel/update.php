<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Кадры'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
    array('label'=>'Список', 'url'=>array('index')),
    array('label'=>'Создать', 'url'=>array('create')),
    array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Управление ', 'url'=>array('admin')),
);
    $this->menu["details"]=array(
array('label'=>'Рабочее место', 'url'=>array('Workplace/admin', 'id_personnel'=>$model->id)),
array('label'=>'Занимаемые должности', 'url'=>array('PersonnelPostsHistory/admin', 'id_personnel'=>$model->id)),
);


?>

<h1>Сотрудник <u><?php echo ($model->surname.' '.$model->name.' '.$model->patr); ?></u></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>