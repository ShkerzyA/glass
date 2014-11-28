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
   			<th>Тип</th>
   			<th>Производитель</th>
   			<th>Модель</th>
   			<th>Инвентарный номер</th>
   			<th>Состояние</th>
   			<th>Примечания</th>

            <?php if($rul) echo '<th>Редактировать</th>'; ?>
   		</tr>
<?php
   	foreach ($equipments as $eq){
         if($rul){
            $edit='<td><a href="'.$this->createUrl('/equipment/update/',array('id'=>$eq->id)).'"><img src="'.$this->createUrl('/images/update.png').'"></a>';
            $edit.=CHtml::link('<img src="'.$this->createUrl('/images/delete.png').'">','#',array('submit'=>array('/equipment/delete','id'=>$eq->id),'confirm' => 'Вы уверены?')).' ';
            $edit.='<img class="showlog" style="cursor: pointer;" id="'.$eq->id.'" src="'.$this->createUrl('/images/view.png').'"></td>';
         }else{
            $edit='';
         }
         $producer=(!empty($eq->producer))?$eq->producer0->name:'';
   		echo'<tr><td>'.$eq->serial.'</td><td>'.$eq->type0->name.'</td><td>'.$producer.'</td><td>'.$eq->mark.'</td><td>'.$eq->inv.'</td><td>'.$status[$eq->status].'</td><td>'.$eq->notes.'</td>'.$edit.'</tr>';
   
      }
?>
</table>	