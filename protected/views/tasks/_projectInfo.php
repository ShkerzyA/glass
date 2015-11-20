<?php
foreach ($project as $v) {
	echo '<img  height=32 src="'.Yii::app()->request->baseUrl.'/images/'.$v['ico'].'" title="'.$v['label'].'">('.$v['my'].'/'.$v['cou'].')';
}


?>