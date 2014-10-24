<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];
?>


<div>
<?php
   	foreach ($equipments as $eq){
   		echo '<div>'.$eq->full_name().'</div>';
   	}
?>
</div>