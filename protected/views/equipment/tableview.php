<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];
$status=$equipments[0]->getStatus();
$rul=Yii::app()->user->checkAccess("ruleWorkplaces");
?>

   	<table class=phonetable>
   		<tr>
   			<th>Серийный номер</th>
   			<th>Модель</th>
   			<th>Инвентарный номер</th>
   			<th>Состояние</th>
   			<th>Примечания</th>

            <?php if($rul) echo '<th>Редактировать</th>'; ?>
   		</tr>
<?php
   foreach ($equipments as $data){
      $this->renderPartial('/equipment/_view',array('data'=>$data,'status'=>$status,'rul'=>$rul),false,false);
   }
?>
</table>	