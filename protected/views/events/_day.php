<div class=leaf>
	<input name="print" class="hide_p" type="button" style="float: right; width: 200px"value="Печать" onclick="window.print();"> 
	<div class=day>
 		<div>08:00</div>
 		<div>09:00</div>
 		<div>10:00</div>
 		<div>11:00</div>
 		<div>12:00</div>
 		<div>13:00</div>
 		<div>14:00</div>
	 	<div>15:00</div>
 		<div>16:00</div>
 		<div>17:00</div>
 	</div>

	<div class=day_event>
		<table>
			<tr><td>
		<div style="display: none">  
	<?php
	$last_room=NULL;
		foreach ($events as $v){
			if($v->id_room!=$last_room){
				if($v->id_room==$model->id){
					$css=' current ';
				}else{
					$css='';
				}	
				echo'</div></td><td>';
				echo'<div class="week_event '.$css.'">';
				echo'<div class="event " style=" "><nobr>'.$v->idRoom->idCabinet->cname.'('.$v->idRoom->idCabinet->num.')</nobr></div>';
			}

			$status=$v->gimmeStatus();
			$this->renderPartial('/events/_event',array('v'=>$v,'status'=>$status,'week'=>$week),false,false);

			if($v->id_room!=$last_room){
				$last_room=$v->id_room;
			}
		}
	?>
	</tr>
	</table>
	</div>


</div>