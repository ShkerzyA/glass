<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

foreach($cabinets as $cab){
	echo '<a href='.$this->createUrl('/Cabinet/view',array('id'=>$cab->id)).'><div class="taskpanel">'.$cab->cname.' '.$cab->num.'</div></a>';
}
	
?>
	
