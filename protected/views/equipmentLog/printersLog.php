<?php
/* @var $this EquipmentLogController */
/* @var $model EquipmentLog */

$this->breadcrumbs=array(
	'Оборудование'=>array('/equipment'),
	'Лог принтеров',
);
?>

<div class="search-form">
<?php $this->renderPartial('_searchPrintLog',array(
	'model'=>$model,
)); ?>
</div>

<table class="phonetable">
	<tr>
		<th>Принтер</th>
		<th>Местоположение</th>
		<th>Количество заправок</th>
	</tr>
<?php
foreach ($models as $m) {
	echo '<tr><td><a href="/glass/equipment/'.$m['object'].'">'.$m['mark'].'/'.$m['serial'].'</a></td><td>'.$m['place'].'</td><td>'.$m['cou'].'</td></tr>';
	# code...
}
?>
</table>
