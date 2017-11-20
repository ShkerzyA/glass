<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';

			echo '<tr><td>'.$data->workplacesPhones().'</td><td><b>'.$data->wrapFio('fio_full').'</b></td><td>';
			echo $data->allCab();
			$this->renderPartial('/persProgram/_tabview',array('model'=>$data),false,false);
			echo '</td></tr>';

?>
