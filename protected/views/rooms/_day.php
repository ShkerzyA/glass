<div class=leaf_slim>

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
	<?php
		$w=array(1=>'Понедельник',2=>'Вторник',3=>'Среда',4=>'Четверг',5=>'Пятница',6=>'Суббота',7=>'Воскресенье');
		echo'<div class="event" style="top: -35px;  font-size: 18pt; text-align: center;">'.$week['begin']->format('d.m.Y').'('.$w[$week['begin']->format('N')].')</div>';
		foreach ($events as $v){

			if(!($v->isShow($week['begin']))){
				continue;
			}

			$time1=explode(':', $v->timestamp);
			$time2=explode(':', $v->timestamp_end);

			$x1=($time1[0]*60+$time1[1]);
			$x2=($time2[0]*60+$time2[1]);

			$top=($x1-480)*1.2;
			$height=($x2-$x1)*1.2;

			$status=$v->gimmeStatus();
			echo'<a href='.Yii::app()->request->baseUrl.'/events/'.$v->id.'>';
			echo '<div class="event '.$status['css_class'].'" style="top: '.$top.'px; height: '.$height.'px">';
				echo '<p>'.$v->name.'</p>';
				//echo '<div class=corps>'.$v->description.'</div>';
				echo '<div class=status>'.$status['label'].'</div>';
				echo '<div class=time>'.$v->timestamp.' - '.$v->timestamp_end.'</div>';
				echo '<div class=creator>'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.'</div>';
			echo '</div></a>';
		}
	?>
	</div>

</div>