<?php
/* @var $this PersonnelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кадры',
);
if (Yii::app()->user->name=='admin'){
$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление кадрами', 'url'=>array('admin')),
);
}
?>

<table class='phonetable' style="table-layout: auto" >
	<tr>
		<th>Телефон</th><th>ФИО/Кабинет</th><th>Подробности</th>
	</tr>
<?php
foreach ($models as $v) {
	$this->renderPartial('_tableview',array('data'=>$v));
}

?>
</table>