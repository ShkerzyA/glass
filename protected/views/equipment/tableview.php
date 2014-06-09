<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
$type=$equipments[0]->getType();
$producer=$equipments[0]->getProducer()['values'];
$status=$equipments[0]->getStatus();
?>

   	<table class=phonetable>
   		<tr>
   			<th>Серийный номер</th>
   			<th>Тип</th>
   			<th>Производитель</th>
   			<th>Модель</th>
   			<th>Инвентарный номер</th>
   			<th>Состояние</th>
   			<th>Примечания</th>
   		</tr>
<?php
   	foreach ($equipments as $eq){
   		echo'<tr><td>'.$eq->serial.'</td><td>'.$type[$eq->type].'</td><td>'.$producer[$eq->producer].'</td><td>'.$eq->mark.'</td><td>'.$eq->inv.'</td><td>'.$status[$eq->status].'</td><td>'.$eq->notes.'</td></tr>';
   	}
?>
</table>	