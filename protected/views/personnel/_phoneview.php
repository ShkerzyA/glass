<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';

			echo '<tr><td>'.$data->workplacesPhones().'</td><td><b>'.$data->fio_full().'</b></td><td>';
			echo $data->allCab();
			echo '</td></tr>';

?>
