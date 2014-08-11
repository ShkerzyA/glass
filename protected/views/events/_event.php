<?php
		if($v->isShow($week['begin'])){
			
			$time1=explode(':', $v->timestamp);
			$time2=explode(':', $v->timestamp_end);

			$x1=($time1[0]*60+$time1[1]+20);
			$x2=($time2[0]*60+$time2[1]+20);

			$top=($x1-480);
			$height=($x2-$x1);
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