<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];


$rul=Yii::app()->user->checkAccess("ruleWorkplaces");
?>

   	<table class=phonetable style="width: auto">

   		<tr>
   			<th colspan=4>DHCP</th>
   			<th colspan=2>База оборудования</th>
   		</tr> 
   		<tr>
   			<th>Дата окончания аренды</th>
   			<th>HOSTNAME</th>
   			<th>IP</th>
   			<th>MAC</th>
   			<th>Оборудование</th>
   			<th>NETINFO</th>
   		</tr> 

<?php
	$this->renderPartial('adminMenu',array());
   	foreach ($models as $dhcp){
   		if(!empty($dhcp->equipment)){
   			$style='done';
   			$eq='<a target=_blank href='.Yii::app()->request->baseUrl.'/equipment/update/'.$dhcp->equipment->id.'><img src='.Yii::app()->request->baseUrl.'/images/update.png></a>'.$dhcp->equipment->getWorkplace().' '.$dhcp->equipment->full_name();
   			$netinfo=$dhcp->equipment->netInfo();
   			$err=(!$dhcp->allIdent())?'red':'';
   		}else{
   			$style='closed';
   			$eq='';
   			$err='';
   			$netinfo='';
   		}
      	echo '<tr class="'.$style.' '.$err.'">';
   		echo '<td>'.$dhcp->date_end.'</td><td>'.$dhcp->hostname.'</td><td>'.$dhcp->ip.'</td><td>'.$dhcp->mac.'</td>';
   		echo '<td>'.$eq.'</td>';
   		echo '<td>'.$netinfo.'</td>';
   		echo '</tr>';
      }
?>
</table>	

