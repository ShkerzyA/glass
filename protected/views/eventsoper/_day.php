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
				echo'</div>';
				echo'<div class="week_event '.$css.'">';
				echo'<div class="event " style="top: -20px; "><nobr>'.$v->idRoom->idCabinet->cname.'</nobr></div>';

			}

			$time1=explode(':', $v->timestamp);
			$time2=explode(':', $v->timestamp_end);

			$x1=($time1[0]*60+$time1[1]);
			$x2=($time2[0]*60+$time2[1]);

			$top=($x1-480);
			$height=($x2-$x1);

			$status=$v->gimmeStatus();
			echo'<a href='.Yii::app()->request->baseUrl.'/eventsoper/'.$v->id.' title="'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.'('.$status['label'].')">';
			echo '<div class="event '.$status['css_class'].'" style="top: '.$top.'px; height: '.$height.'px">';
				echo '<p>'.$v->operation0->name.'</p>';
				//echo '<div class=corps>'.$v->description.'</div>';
				echo '<div class=status>'.$status['label'].'</div>';
				// echo '<div class=time>'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.'</div>';
				echo '<div class=creator>'.$v->timestamp.' - '.$v->timestamp_end.'</div>';
			echo '</div>';
			echo'</a>';

			if($v->id_room!=$last_room){
				$last_room=$v->id_room;
			}
		}


	?>
	</div>

</div>