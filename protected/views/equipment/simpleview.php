<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];
$status=$model->equipments[0]->getStatus();
?>
<div style="clear: both"></div>
   	<table class=phonetable>
   		<tr>
   			<th>Серийный номер</th>
   			<th>Модель</th>
   			<th>Инвентарный номер</th>
   			<th>Состояние/Дата выпуска</th>
   			<th>Примечания</th>
   		</tr>
<?php $date='';?>
<?php
   foreach ($model->equipments as $data){
      $this->renderPartial('/equipment/_view',array('data'=>$data,'status'=>$status,'rul'=>false),false,false);
   }
?>
</table>	
<?php echo CHtml::endForm(); ?>