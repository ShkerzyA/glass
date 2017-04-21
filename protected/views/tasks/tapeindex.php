<?php
/* @var $this TasksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Лента',
);

$this->menu=array(
	array('label'=>'К текущим задачам', 'url'=>array('helpdesk')),
);

?>
<div style="clear: both"></div>
<br>

<h1>Лента</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_tapeitem',
)); ?>
