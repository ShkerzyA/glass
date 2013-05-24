<?php
/* @var $this CabinetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cabinets',
);

$this->menu=array(
	array('label'=>'Create Cabinet', 'url'=>array('create')),
	array('label'=>'Manage Cabinet', 'url'=>array('admin')),
);
?>

<h1>Cabinets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
