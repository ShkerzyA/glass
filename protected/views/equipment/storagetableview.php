<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];


$rul=Yii::app()->user->checkAccess("ruleWorkplaces");
?>
<!--
   	<table class=phonetable style="width: auto">
   		<tr>
   			<th>Модель</th>
   			<th>Количество</th>
   		</tr> -->
<?php
   	foreach ($equipments as $eq){
      
   		//echo'<tr><td>'.$eq['type'].' '.$eq['producer'].' '.$eq['mark'].'</td><td>'.$eq['num'].'</td></tr>';
         echo'<div style="position: relative; overflow: hidden; float: left; width: 300px; margin:0 10px 5px 10px ; padding: 2px; border-bottom: 1px solid grey;">'.$eq['type'].' '.$eq['producer'].' <span class="filter_eq" style="color: #06c; cursor: pointer;"> '.$eq['mark'].'</span> <span style="position: relative; float: right;"> '.$eq['num'].' ед.</span></div>';
   
      }
?>
</table>	

