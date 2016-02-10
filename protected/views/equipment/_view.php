<?php

         if($rul){
            $edit='<td><a href="'.$this->createUrl('/equipment/update/',array('id'=>$data->id)).'"><img src="'.$this->createUrl('/images/update.png').'"></a>';
            $edit.=CHtml::link('<img src="'.$this->createUrl('/images/delete.png').'">','#',array('submit'=>array('/equipment/delete','id'=>$data->id),'confirm' => 'Вы уверены?')).' ';
            $edit.='<img class="showlog" style="cursor: pointer;" id="'.$data->id.'" src="'.$this->createUrl('/images/view.png').'">';
            $edit.='<input type=checkbox style="width: 10px;" name=EquipmentMass[id][] value="'.$data->id.'">';
            $edit.='</td>';
         }else{
            $edit='';
         }
         $producer=(isset($data->producer))?$data->producer0->name:'';
   		echo'<tr class="str_eq"><td>'.$data->serial.'</td><td>'.$data->type0->name.'/ '.$producer.'/ '.$data->mark.'</td><td>'.$data->inv.'</td><td>'.$status[$data->status].' '.$data->logInfo().'<br>'.$data->released.'</td><td>'.$data->notes.''.($pid=(!empty($data->parent_id))?'(pid '.$data->parent_id.')':'').$data->netinfo().'</td>'.$edit.'</tr>';
   
?>