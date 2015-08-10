<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Массовое изменение',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Массовое изменение моделей</h1>
<h4>Пустые поля - различаются у выборки моделей. Заполенные поля - одинаковые у выборки. При сохранении значения заполненных полей присваиваются всей выборке. Пустые остаются неизменными</h4>

<?php echo $this->renderPartial('_form', array('model'=>$model,'mass_id'=>$mass_id)); ?>