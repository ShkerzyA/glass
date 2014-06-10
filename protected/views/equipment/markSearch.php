
/* @var $this EquipmentController */
/* @var $model Equipment */


<div class="back">
<div class="window_awesom">
<div id="back" class='close_this'></div>

<br>

<?php
foreach ($model as $v) {
	echo '<div class=add_mark id='.$v->id.'>'.$v->mark.'</div>';
	# code...
}

?>

</div></div>


