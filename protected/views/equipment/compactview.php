<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
$type=$equipments[0]->getType();
$producer=$equipments[0]->getProducer()['values'];
?>


<div>
<?php
   	foreach ($equipments as $eq){
   		echo '<div>'.$type[$eq->type].' '.$producer[$eq->producer].' '.$eq->mark.'</div>';
   	}
?>
</div>