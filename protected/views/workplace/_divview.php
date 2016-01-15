<?php
$phone=(!empty($wp->phone))?'(тел. '.$wp->phone.')':'';
			echo'<a href="'.Yii::app()->request->baseUrl.'/Workplace/'.$wp->id.'"><div class="hipanel open">';
			if(!empty($wp->idPersonnel)){
				echo '<h4>'.$wp->idPersonnel->fio_full().' '.$phone.'</h4>';	
			}else{
				echo '<h4>'.$wp->wname.'  '.$phone.'</h4>';
			}

			if(!empty($wp->equipments)){
				switch ($wp->type) {
					case '1':
					case '2':
						$this->renderPartial('/equipment/storagetableview',array('equipments'=>$wp->eqCount()),false,false); 
						break;
					
					default:
						$this->renderPartial('/equipment/compactview',array('equipments'=>$wp->equipments),false,false); 
						break;
				}
			}

		echo "</div></a>";
?>