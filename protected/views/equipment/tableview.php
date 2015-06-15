<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];
$status=$model->equipments[0]->getStatus();
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
<?php $date='';?>
<?php
   foreach ($model->equipments as $data){
      if($model->type=2 and !empty($data->EquipmentLog) and $data->EquipmentLog[0]->timestamp!=$date){
         $date=$data->EquipmentLog[0]->timestamp;
         $this->renderPartial('/equipment/_date',array('date'=>$date),false,false);
      }
      $this->renderPartial('/equipment/_view',array('data'=>$data,'status'=>$status,'rul'=>$rul),false,false);
   }
?>
</table>	