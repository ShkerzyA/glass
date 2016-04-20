<?php
  $dl=$model->getLocks();
  foreach ($dl as $l) {
      echo '<img src="'.Yii::app()->request->baseUrl.'/images/locks/'.$l[1].$l[0].'.png" title="'.$l[2].'">';
  } 
?>