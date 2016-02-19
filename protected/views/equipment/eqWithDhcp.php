<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
//$type=$equipments[0]->getType();
//$producer=$equipments[0]->getProducer()['values'];


$rul=Yii::app()->user->checkAccess("ruleWorkplaces");
?>

   	<table class="phonetable toptext" style="width: auto">

   		<tr>
            <th colspan=2>База оборудования</th>
   			<th colspan=4>DHCP</th>
   		</tr> 
   		<tr>
            <th>Оборудование</th>
            <th>NETINFO</th>
   			<th>Дата окончания аренды</th>
   			<th>HOSTNAME</th>
   			<th>IP</th>
   			<th>MAC</th>
   		</tr> 

<?php
	$this->renderPartial('adminMenu',array());
   	foreach ($models as $eq){
         $rows=1;
         $dhcp=array();
   		if(!empty($eq->dhcp)){
            $style='done';
            foreach ($eq->dhcp as $dh) {
               $rows++;
               $dhcp[]='<tr class="'.$style.'"><td>'.$dh->date_end.'</td><td>'.$dh->hostname.'</td><td>'.$dh->ip.'</td><td>'.$dh->mac.'</td></tr>';
            }
   		}else{
            $style='closed';
         }
   		echo '<tr class="'.$style.'"><td class=nob rowspan='.$rows.'>'.$eq->getWorkplace().' '.$eq->full_name().'</td>';
   		echo '<td class=nob rowspan='.$rows.'>'.$eq->netInfo().'</td>';
         echo '<td colspan=4 class=nob> </td>';
   		echo '</tr>';
         echo implode("\n",$dhcp);
      }
?>
</table>	

