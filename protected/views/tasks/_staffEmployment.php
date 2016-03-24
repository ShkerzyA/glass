<div style="height: 20px;">
<?php
foreach ($staffEpl as $v) {
	$ava=Personnel::stAva($v['photo']);
	echo '<img height=100% src="'.$ava.'" title="'.$v['surname'].' '.$v['name'].' '.$v['patr'].'">('.$v['tasks'].')   ';
}
?>
</div>