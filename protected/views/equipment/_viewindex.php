<?php
         if($rul){
            $edit='<td rowspan=2><a href="'.$this->createUrl('/equipment/update/',array('id'=>$data->id)).'"><img src="'.$this->createUrl('/images/update.png').'"></a>';
            $edit.=CHtml::link('<img src="'.$this->createUrl('/images/delete.png').'">','#',array('submit'=>array('/equipment/delete','id'=>$data->id),'confirm' => 'Вы уверены?')).' ';
            $edit.='<img class="showlog" style="cursor: pointer;" id="'.$data->id.'" src="'.$this->createUrl('/images/view.png').'"></td>';
         }else{
            $edit='';
         }
         $producer=(isset($data->producer))?$data->producer0->name:'';
   		echo'<tr><td>SN: <b>'.$data->serial.'</b></td><td rowspan=2>'.$data->type0->name.'/ '.$producer.'/ '.$data->mark.'</td><td rowspan=2>'.$data->idWorkplace->wpNameFull().'</td><td rowspan=2>'.$status[$data->status].'</td><td rowspan=2>'.$data->notes.'</td>'.$edit.'</tr>';
   		echo'<tr><td>INV: <b>'.$data->inv.'</b></td></tr>';
?>