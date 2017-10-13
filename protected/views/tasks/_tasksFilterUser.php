<?php

$personnel=Personnel::groupMembers(Yii::app()->user->groups,true);

$persArr=array();
foreach ($personnel as $pr) {
	if(is_object($pr))
	$persArr[]=array('label'=>'<nobr>'.$pr->fio_full().'</nobr>','url'=>array('tasks/HelpDesk?group=&&type=2&&id_pers='.$pr->id.''));
}


$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'<img src="'.Yii::app()->request->baseUrl.'/images/chain24.png">Фильтр по пользователям',
          'contentCssClass'=>'portlet-content hide',
				));

$this->widget('zii.widgets.CMenu', array(
        'items'=>$persArr,
        'encodeLabel'=>false,
        'htmlOptions'=>array('class'=>'operations'),
      ));

$this->endWidget();






?>
