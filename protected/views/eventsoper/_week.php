<div class=leaf>
	<input name="print" class="hide_p" type="button" style="float: right; width: 200px;"value="Печать" onclick="window.print();"> 
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

	while ($week['begin']<=$week['end']) {

		$diff=$week['begin']->diff(Yii::app()->session['Rooms_date']);
		if($diff->format('%d')<1){
			$css=' current ';
		}else{
			$css='';
		}
		# code...
		echo'<div class="week_event '.$css.'">';
			

			echo'<div class="event " style="">'.$week['begin']->format('d.m.Y').'('.$w[$week['begin']->format('N')].')</div>';
		foreach ($events as $v){

			


			if(!($v->isShow($week['begin']))){
				continue;
			}



			$status=$v->gimmeStatus();
			$this->renderPartial('/eventsoper/_event',array('v'=>$v,'status'=>$status),false,false);

			
		}
		echo'</div>';
		$week['begin']->modify('+1 days');
	}

	?>
	</div>

</div>