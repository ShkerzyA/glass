<?php
         if($rul){
            $edit='<td><a href="'.$this->createUrl('/equipment/update/',array('id'=>$data->id)).'"><img src="'.$this->createUrl('/images/update.png').'"></a>';
            $edit.=CHtml::link('<img src="'.$this->createUrl('/images/delete.png').'">','#',array('submit'=>array('/equipment/delete','id'=>$data->id),'confirm' => 'Вы уверены?')).' ';
            $edit.='<img class="showlog" style="cursor: pointer;" id="'.$data->id.'" src="'.$this->createUrl('/images/view.png').'"></td>';
         }else{
            $edit='';
         }
         $producer=(!empty($data->producer))?$data->producer0->name:'';
   		echo'<tr><td>'.$data->serial.'</td><td>'.$data->type0->name.'</td><td>'.$producer.'</td><td>'.$data->mark.'</td><td>'.$data->inv.'</td><td>'.$status[$data->status].'</td><td>'.$data->notes.'</td>'.$edit.'</tr>';
   
?>