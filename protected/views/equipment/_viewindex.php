<?php
         if($rul){
            $edit='<td rowspan=2><a href="'.$this->createUrl('/equipment/update/',array('id'=>$data->id)).'"><img src="'.$this->createUrl('/images/update.png').'"></a>';
            $edit.=CHtml::link('<img src="'.$this->createUrl('/images/delete.png').'">','#',array('submit'=>array('/equipment/delete','id'=>$data->id),'confirm' => 'Вы уверены?')).' ';
            $edit.='<img class="showlog" style="cursor: pointer;" id="'.$data->id.'" src="'.$this->createUrl('/images/view.png').'">';
            $edit.='<input type=checkbox class="mass_checkbox" style="width: 10px;" name=EquipmentMass[id][] value="'.$data->id.'">';
            $edit.='</td>';
         }else{
            $edit='';
         }
         $producer=(isset($data->producer))?$data->producer0->name:'';
   		echo'<tr class="str_eq"><td>SN: <b>'.$data->serial.'</b></td><td rowspan=2>'.$data->type0->name.'/ '.$producer.'/ '.$data->mark.'</td><td rowspan=2>'.$data->idWorkplace->wpNameFull().'</td><td>'.$status[$data->status].'</td><td rowspan=2>'.($actinfo=(!empty($data->actsoftransfers))?'<img class="actFind" id="'.$data->id.'" src="'.$this->createUrl('/images/report24.png').'">':'').$data->notes.$data->additionalInfo().'<br>'.($pid=(!empty($data->parent_id))?'(pid '.$data->parent_id.')':'').$data->netinfo().'</td>'.$edit.'</tr>';
   		echo'<tr><td>INV: <b>'.$data->inv.'</b></td><td>'.$data->released.'</td></tr>';
?>