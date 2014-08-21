<?php

			
			$time1=explode(':', $v->timestamp);
			$time2=explode(':', $v->timestamp_end);

			$x1=($time1[0]*60+$time1[1]+20);
			$x2=($time2[0]*60+$time2[1]+20);

			$top=($x1-480);
			$height=($x2-$x1);
			echo'<a href='.Yii::app()->request->baseUrl.'/eventsoper/'.$v->id.' title="'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.'('.$status['label'].')">';
			echo '<div class="event '.$status['css_class'].'" style="top: '.$top.'px; height: '.$height.'px">';
				echo '<div class=information><p>'.$v->operation0->name.'</p>';
				echo 'Оператор: '.CHtml::encode($v->operator0->surname.' '.mb_substr($v->operator0->name,0,1,'utf-8').'. '.mb_substr($v->operator0->patr,0,1,'utf-8')).'.<br>'; 
   				//echo 'Анестезиолог: '.CHtml::encode($v->anesthesiologist0->surname.' '.mb_substr($v->anesthesiologist0->name,0,1,'utf-8').'. '.mb_substr($v->anesthesiologist0->patr,0,1,'utf-8')).'.<br>';
				$tmp=explode(',',$v->anesthesiologists); 
				$exec=array();
				foreach ($tmp as $x){
					if(!empty($x)){
						$pers=Personnel::model()->findByPk($x);
						$exec[]=CHtml::encode($pers->surname.' '.mb_substr($pers->name,0,1,'utf-8').'. '.mb_substr($pers->patr,0,1,'utf-8').'. ');
					}
				}	
				echo 'Анестезиологи: '.(implode(', ', $exec)); 

				echo '</div>';
				//echo '<div class=corps>'.$v->description.'</div>';
				echo '<div class=status>'.$status['label'].'</div>';
				// echo '<div class=time>'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.'</div>';
				echo '<div class=creator>'.$v->timestamp.' - '.$v->timestamp_end.'</div>';
			echo '</div>';
			echo'</a>'; 
?>