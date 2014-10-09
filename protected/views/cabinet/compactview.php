<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

foreach($cabinets as $cab){
	echo '<a href='.$this->createUrl('/Cabinet/view',array('id'=>$cab->id)).'><div class="taskpanel">'.$cab->num.' '.$cab->cname.' <span style="float: right"> '.($ph=(!empty($cab->phone))?'тел.'.$cab->phone:'').'</span></div></a>';
}
	
?>
	
