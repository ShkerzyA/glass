<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];
$status=$model->equipments[0]->getStatus();
$rul=Yii::app()->user->checkAccess("ruleWorkplaces");
?>
<?php echo CHtml::beginForm('/glass/Equipment/massUpd','post'); ?>
<?php $this->renderPartial('/workplace/massUpd'); ?>
<div style="clear: both"></div>
   	<table class=phonetable>
   		<tr>
   			<th>Серийный номер</th>
   			<th>Модель</th>
   			<th>Инвентарный номер</th>
   			<th>Состояние/Дата выпуска</th>
   			<th>Примечания</th>

            <?php if($rul) echo '<th>Редактировать</th>'; ?>
   		</tr>
<?php $date='';?>
<?php
   foreach ($model->equipments as $data){
      if(isset($model->type) and $model->type==2 and !empty($data->EquipmentLog) and $data->EquipmentLog[0]->timestamp!=$date){
         $date=$data->EquipmentLog[0]->timestamp;
         $this->renderPartial('/equipment/_date',array('date'=>$date,'rul'=>$rul),false,false);
      }
      $this->renderPartial('/equipment/_view',array('data'=>$data,'status'=>$status,'rul'=>$rul),false,false);
   }
?>
</table>	
<?php echo CHtml::endForm(); ?>